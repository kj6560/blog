<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function createSlug($string)
    {
        // Convert the string to lowercase
        $string = strtolower($string);

        // Remove special characters using regex
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);

        // Replace spaces with hyphens
        $string = str_replace(' ', '-', $string);

        // Remove consecutive hyphens
        $string = preg_replace('/-+/', '-', $string);

        // Trim hyphens from the beginning and end of the string
        $string = trim($string, '-');

        return $string;
    }
    public function uploadFile($file, $path)
    {
        $response = array();
        try {
            $errors = array();
            $file_name = time() . "_" . trim($file['name']);
            $file_size = $file['size'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(explode('.', $file['name'])[1]);

            $extensions = array("jpeg", "jpg", "png", "csv");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($file_size > 209715200) {
                $errors[] = 'File size must be excately 200 MB';
            }
            if (move_uploaded_file($file_tmp, "uploads/" . $path . "/" . $file_name)) {
                $response['errors'] = $errors;
                $response['success'] = false;
                $response['file_name'] = $file_name;
                return $response;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        return $response;
    }
    public function deleteFile($filename, $path)
    {
        $response = array();
        $response['errors'] = false;
        $response['success'] = false;
        $response['file_name'] = $filename;
        echo "uploads/" . $path . "/" . $filename;
        if (file_exists("uploads/" . $path . "/" . $filename) && unlink("uploads/" . $path . "/" . $filename)) {
            $response['errors'] = true;
            $response['success'] = true;
            return $response;
        } else {
            echo "file doesn't exist";
        }
        return $response;
    }
    public function adjustPriority($currentImagesWithPriority, $image_priority, $image)
    {
        $existing = [];

        foreach ($currentImagesWithPriority as $key => $value) {
            $existing[$value['image']] = $value['image_priority'];
        }
        $response = $this->processPriority($existing, $image_priority, $image);
        return $response;
    }
    public function processPriority($existing, $priotiy, $key_priority)
    {
        if (in_array($priotiy, array_values($existing)) == false) {
            return true;
        }
        asort($existing);
        $toProcess = [];
        foreach ($existing as $key => $val) {
            if ($val == $priotiy) {
                $toProcess[$key] = $val;
                unset($existing[$key]);
            }
        }

        foreach ($existing as $key => $val) {
            if ($val > $priotiy)
                $existing[$key] = $val + 1;
        }
        $existing = array_merge($existing, array($key_priority => $priotiy));
        foreach ($toProcess as $key => $val) {
            $toProcess[$key] = $val + 1;
        }
        $final_array = array_merge($existing, $toProcess);
        $return = false;
        foreach ($final_array as $key => $val) {
            $image = DB::table("site_gallery")->where("image", $key)->update(["image_priority" => $val]);
            if ($image) {
                $return = true;
            } else {
                $return = false;
            }
        }
        return $return;
    }
    public function getSettings()
    {
        $settings = SiteSettings::all();
        $all_settings = array();
        foreach ($settings as $setting) {
            $all_settings[$setting['site_key']] = $setting['site_value'];
        }
        return $all_settings;
    }
    public function processFilter($data)
    {
        $return = "";
        if (!empty($data)) {
            $user_name = $data['user_name'];
            if (!empty($user_name)) {
                $user_name_arr = explode(' ', $user_name);
                if (!empty($user_name_arr[0])) {
                    $first_name = $user_name_arr[0];
                    $return .= "users.first_name like '" . $first_name . "%'";
                }

                if (!empty($user_name_arr[1])) {
                    $last_name = $user_name_arr[1];
                    if ($return == "")
                        $return .= " users.last_name like '" . $last_name . "%'";
                    else
                        $return .= " AND users.last_name like '" . $last_name . "%'";
                }
            }

            if (!empty($data['user_email'])) {
                $email = $data['user_email'];
                if ($return == "")
                    $return .= "users.email like '" . $email . "%'";
                else
                    $return .= "AND users.email like '" . $email . "%'";
            }

            if (!empty($data['city'])) {
                $city = $data['city'];
                if ($return == "")
                    $return .= "user_address_details.city like '" . $city . "%'";
                else
                    $return .= "AND user_address_details.city like '" . $city . "%'";
            }

            if (!empty($data['state'])) {
                $state = $data['state'];
                if ($return == "")
                    $return .= "user_address_details.state like '" . $state . "%'";
                else
                    $return .= "AND user_address_details.state like '" . $state . "%'";
            }

            if (!empty($data['number'])) {
                $number = $data['number'];
                if ($return == "")
                    $return .= "users.number = '" . $number . "' ";
                else
                    $return .= "AND users.number = '" . $number . "' ";
            }

            if (!empty($data['pincode'])) {
                $pincode = $data['pincode'];
                if ($return == "")
                    $return .= "user_address_details.pincode like '" . $pincode . "%'";
                else
                    $return .= "AND user_address_details.pincode like '" . $pincode . "%'";
            }
        }
        return $return;
    }
}
