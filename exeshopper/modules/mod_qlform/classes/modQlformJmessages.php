<?php
/**
 * @package		mod_qlform
 * @copyright	Copyright (C) 2014 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class modQlformJmessages
{
    /**
     * method for mailing using JoomlaMailer
     *
     * @param   string    $to      recipient of mail
     * @param   string 	$subject for mail
     * @param   array  $data post data from form
     *
     * @return  bool  True on success, false on failure
     */
    public function __construct()
    {
        $this->db=new modQlformDatabase();
    }
    /**
	 * method for mailing using JoomlaMailer
	 *
	 * @param   string    $to      recipient of mail
	 * @param   string 	$subject for mail
	 * @param   array  $data post data from form
	 *
	 * @return  bool  True on success, false on failure
	 */
	public function save($data)
	{
        $this->db->save('#__messages',$data);
        return true;
	}
	
	/**
	 * method to generate headline and body of mail 
	 *  
	 * @param array $data
	 * @param string $subject
	 */
	public function getData($recipient,$sender,$subject,$message)
	{
        $data=array();
        $data['user_id_from']=$sender;
        $data['user_id_to']=$recipient;
        $data['subject']=$subject;
        $data['message']=$message;
        $data['state']=0;
        $data['date_time']=date('Y-m-d H:i:s');
        $data['priority']=0;
        return $data;
	}

    /**
     * Method to check validation of e-mail address
     *
     * @param	string	$str wouldbe-email address
     * @return  bool    true on success; false on failure
     */
	public function getDataAsString($data,$strtype='json',$separator='#')
	{
        switch ($strtype)
        {
            case 'bare':
                $data=$this->subarrayToJson($data);
                $str='';
                foreach($data as $k=>$v)$str.='<div><strong>'.$k.'</strong></div><div>'.$v.'</div><p />';
                break;
            case 'implode':
                $str=implode($this->subarrayToJson($data),$separator);
                break;
            case 'dump':
                $str=$this->dump($data);
                break;
            case 'serialize':
                $str=serialize($data);
                break;
            case 'json':
            default :
                $str=json_encode($data);
                break;
        }
        return $str;
    }
    /**
     * method to turn subarray into string via json_encode
     *
     * @param array $array multidimensional array
     * @return array $array array containing subarray as jsonified strings
     */
    function subarrayToJson($array)
    {
        if (is_array($array)) while (list($k,$v)=each($array)) if (is_array($v)) $array[$k]=json_encode($v);
        return $array;
    }
    /**
     * method to turn content vor array or object to string
     * that the developer of this module could never have guessed
     *
     * @param mixed $variable at your service
     */
    function dump($data,$type='var_dump')
    {
        if ('var_dump'==$type)
        {
            ob_start();
            var_dump($data);
            $str_data=ob_get_contents();
            ob_end_clean();
        }
        elseif ('foreachstring'==$type)
        {
            $str_data='';
            foreach ($data as $k=>$v)
            {
                $str_data.='col['.$k.']=>'.$v.'<br />';
            }
        }
        return $str_data;
    }
}