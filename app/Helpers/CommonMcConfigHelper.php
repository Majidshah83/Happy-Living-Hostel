<?php
namespace App\Helpers;
use Auth;

use Illuminate\Support\Facades\Schema;
use App\Models\CommonModel;
use App\Models\GlobalSettings;

use Config;

class CommonMcConfigHelper
{

    // Start => public function get_form_config()
    public static function get_form_config(){

        $response_array = array();

        $response_array['regex_arr'] = array();

        $response_array['regex_arr']['validate_titles'] = "/^[a-zA-Z0-9\s()'+,.#&?-]+$/";
        $response_array['regex_arr']['validate_grade'] = '/[a-zA-Z0-9\s+,_.#&?%()-]+$/';
        $response_array['regex_arr']['validate_textareas'] = '/[a-zA-Z0-9\s().,-]+$/';
        $response_array['regex_arr']['combined_address'] = "/^[a-zA-Z0-9\s()'.,-]*$/";
        $response_array['regex_arr']['validate_url_slug'] = "/^[a-zA-Z0-9-\s']*$/";
        $response_array['regex_arr']['validate_mobile_number'] = "/^[0-9+']*$/";
        $response_array['regex_arr']['validate_email'] = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/";
        $response_array['regex_arr']['alphanumeric'] = '/^[\w ]+$/i';
        $response_array['regex_arr']['pharmacy_validate_titles'] = "/^[a-zA-Z0-9\s\-(),]*$/";
        $response_array['regex_arr']['pharmacy_validate_description'] = "/^[a-zA-Z0-9\s\-(),]*$/";
        $response_array['regex_arr']['pharmacy_contact_numbers'] = "/^[0-9\s\-()+ \ ]*$/";
        $response_array['regex_arr']['pharmacy_validate_social_media_urls'] = "/^[a-zA-Z0-9\s():,.\/]*$/";
        
        return $response_array;
        
    } // End => public function get_form_config()

    // Start => public static function get_elo_obj($table_name=false)
    public static function get_elo_obj($table_name=false){

        $fillable =  Schema::getColumnListing($table_name);

        $common_obj = new CommonModel();
        $real_obj = $common_obj->set_config($table_name, $fillable);

        return $real_obj;

    } // End => public static function get_elo_obj($table_name=false)

    /********* START => COMMON CUSTOM MC HELPER FUNCTIONS ********/

    public static function date_format($date=false){

        if($date == false || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') return '';

        $formated_date = date('d/m/Y', strtotime($date));
        return $formated_date;

    } // public static function date_format($date=false)
 
    public static function setEmailConfig()
    {

        $setting_row = GlobalSettings::where('setting_name', 'DEFAULT_MAIL_GATEWAY')->first();

        if($setting_row['setting_value'] == 'AMAZON'){

            // return 'amazon';

            // Get all AMAZON related MAIL settings

            $MAIL_ENCRYPTION = GlobalSettings::where('setting_name', 'AMAZON_MAIL_ENCRYPTION')->first();

            $MAIL_HOST = GlobalSettings::where('setting_name', 'AMAZON_MAIL_HOST')->first();

            $MAIL_PASSWORD = GlobalSettings::where('setting_name', 'AMAZON_MAIL_PASSWORD')->first();

            $MAIL_PORT = GlobalSettings::where('setting_name', 'AMAZON_MAIL_PORT')->first();

            $MAIL_USERNAME = GlobalSettings::where('setting_name', 'AMAZON_MAIL_USERNAME')->first();

        } else if($setting_row['setting_value'] == 'GMAIL'){
            
            // return 'gmail';

            // Get all GMAIL related MAIL settings

            $MAIL_ENCRYPTION = GlobalSettings::where('setting_name', 'GMAIL_MAIL_ENCRYPTION')->first();

            $MAIL_HOST = GlobalSettings::where('setting_name', 'GMAIL_MAIL_HOST')->first();

            $MAIL_PASSWORD = GlobalSettings::where('setting_name', 'GMAIL_MAIL_PASSWORD')->first();

            $MAIL_PORT = GlobalSettings::where('setting_name', 'GMAIL_MAIL_PORT')->first();

            $MAIL_USERNAME = GlobalSettings::where('setting_name', 'GMAIL_MAIL_USERNAME')->first();

        } // if($setting_row['setting_value'] == 'AMAZON')

        // return $MAIL_USERNAME->setting_value;

        Config::set('mail.mailers.smtp.encryption', $MAIL_ENCRYPTION->setting_value);

        Config::set('mail.mailers.smtp.host', $MAIL_HOST->setting_value);

        Config::set('mail.mailers.smtp.password', $MAIL_PASSWORD->setting_value);

        Config::set('mail.mailers.smtp.port', $MAIL_PORT->setting_value);

        Config::set('mail.mailers.smtp.username', $MAIL_USERNAME->setting_value);


        // return Config::get('mail.mailers.smtp.host');

        /*
        $mail = [
            'driver'        => 'smtp',
            "transport"     => 'smtp',
            'host'          => 'smtp.mailtrap.io',
            'port'          => 2525,
            'encryption'    => 'tls',
            'username'      => "87f31335a8323e",
            'password'      => "2ac3ffac7e3c3d",
            "from_address"  => "test@example.com",
            "from_name"     => "Pharmacy Name"
        ];

        $config = array(
            'driver'       => $mail["driver"],
            "transport"    => $mail["transport"],
            'host'         => $mail["host"],
            'port'         => $mail["port"],
            'from'         => array('address' => $mail["from_address"], 'name' => $mail["from_name"]),
            'encryption'   => $mail["encryption"],
            'username'     => $mail["username"],
            'password'     => $mail["password"],
            'sendmail'     => '/usr/sbin/sendmail -bs',
            'pretend'      => false,
        );

        //update all config settings
        //Config::set('mail', $config);

        // update single config settings
        Config::set('mail.host',          $mail['host']);
        Config::set('mail.port',          $mail['port']);
        Config::set('mail.encryption',    $mail['encryption']);
        Config::set('mail.username',      $mail['username']);
        Config::set('mail.password',      $mail['password']);
        Config::set('mail.from_address',  $mail['from_address']);
        Config::set('mail.from_name',     $mail['from_name']);
        */

    }

}