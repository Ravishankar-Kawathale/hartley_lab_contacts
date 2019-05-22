
<?php  if( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Vcard
{
    // private CI instance
    private $ci;
    
    // private array for data from caller
    private $data;
    
    // private string for storing the text of the finished card
    private $card_string;
    
    
    public function __construct()
    {
        $this->ci =& get_instance();

    }
    
    
    /** 
     * Vcard class constructor 
     * 
     * Initializes the data array, either to blank values to values
     * provided in the parameters. An optional filename or directory
     * can be  specified to generate the vCard in one step
     * 
     * @access public 
     * @param array $data
     * @param string $filename
     *  
     */ 
    public function Vcard($data = false, $filename = false)
    {
        // initialize the array
        $this->data = array(
            'display_name' => null,
            'first_name' => null,
            'last_name' => null,
            'additional_name' => null,
            'name_prefix' => null,
            'name_suffix' => null,
            'nickname' => null,
            'title' => null,
            'role' => null,
            'department' => null,
            'company' => null,
            'work_po_box' => null,
            'work_extended_address' => null,
            'work_address' => null,
            'work_city' => null,
            'work_state' => null,
            'work_postal_code' => null,
            'work_country' => null,
            'home_po_box' => null,
            'home_extended_address' => null,
            'home_address' => null,
            'home_city' => null,
            'home_state' => null,
            'home_postal_code' => null,
            'home_country' => null,
            'office_tel' => null,
            'home_tel' => null,
            'cell_tel' => null,
            'fax_tel' => null,
            'pager_tel' => null,
            'email1' => null,
            'email2' => null,
            'url' => null,
            'photo' => null,
            'birthday' => null,
            'timezone' => null,
            'sort_string' => null,
            'note' => null,
            'revision_date' => null,
            'class' => null
        );
        
        // check if an array of data was provided
        // if so, add values from the array to the 
        // class data array
        if(is_array($data))
        {
            foreach($data as $item => $value)
            {
                $this->data[$item] = $value;
            }
        }
    
        // check if a filename was provided
        // if so, load the generate_file() method
        if(is_string($filename))
        {
            $this->generate_file($filename);
    
        }
    
    }
    
    
    /** 
     * Load 
     * 
     * Initializes the data array, to values provided in 
     * the parameters. 
     * 
     * @access public 
     * @param array $data
     *  
     */ 
    public function load($data)
    {
        // initialize the array
        $this->data = array(
            'display_name' => null,
            'first_name' => null,
            'last_name' => null,
            'additional_name' => null,
            'name_prefix' => null,
            'name_suffix' => null,
            'nickname' => null,
            'title' => null,
            'role' => null,
            'department' => null,
            'company' => null,
            'work_po_box' => null,
            'work_extended_address' => null,
            'work_address' => null,
            'work_city' => null,
            'work_state' => null,
            'work_postal_code' => null,
            'work_country' => null,
            'home_po_box' => null,
            'home_extended_address' => null,
            'home_address' => null,
            'home_city' => null,
            'home_state' => null,
            'home_postal_code' => null,
            'home_country' => null,
            'office_tel' => null,
            'home_tel' => null,
            'cell_tel' => null,
            'fax_tel' => null,
            'pager_tel' => null,
            'email1' => null,
            'email2' => null,
            'url' => null,
            'photo' => null,
            'birthday' => null,
            'timezone' => null,
            'sort_string' => null,
            'note' => null,
            'revision_date' => null,
            'class' => null
        );
        
        // make sure data array was provided
        // if so, load the values into the class
        // data array
        if(is_array($data))
        {
            foreach($data as $item => $value)
            {
                $this->data[$item] = $value;
            }
        }
    
    }
    
    public function generate_file($filename)
    {
        $this->_build();
        
        if(is_dir($filename))
            $filename .= $this->_build_filename();
        
        $fh = fopen($filename, 'w');
        
        if(!$fh)
            return false;
        
        fwrite($fh, $this->card_string);
        fclose($fh);

        return $filename;
    }
    
    
    /** 
     * generate_string 
     * 
     * Generates a vcf formatted string. 
     * 
     * @access public 
     * @return string vcf formatted data 
     */ 
    public function generate_string()
    {
    
        $this->_build();
        return $this->card_string;
    
    }
    
    
    /** 
     * generate_download 
     * 
     * Generates a vcf file and forces a download to the
     * browser. Accepts a filename If a filename is not 
     * provided, the filename is built from the display 
     * name.
     * 
     * @access public 
     * @param string $filename
     */ 
    public function generate_download($filename = null)
    {
        $this->_build();
        
        if($filename == null)
        {
            $filename = $this->_build_filename();
        
        }
        $this->ci->load->helper('download');
        
        force_download($filename, $this->card_string);     
    
    
    }
    
    
    /** 
     * _build 
     * 
     * Generates a vcf formatted string from the data array 
     * and stores it in the private class variable
     * 
     * @access private 
     */ 
    private function _build()
    {
        /*
        For many of the values, if they are not passed in, we set defaults or
        build them based on other values.
        */

        if(!$this->data['class']) { $this->data['class'] = "PUBLIC"; }
        if(!$this->data['display_name']) 
        {
              $this->data['display_name'] = trim($this->data['first_name']." ".$this->data['last_name']);
        }
        if(!$this->data['sort_string']) { $this->data['sort_string'] = $this->data['last_name']; }
        if(!$this->data['timezone']) { $this->data['timezone'] = date("O"); }
        if(!$this->data['revision_date']) { $this->data['revision_date'] = date('Y-m-d H:i:s'); }
		$this->card_string = "BEGIN:VCARD From HL\r\n";        
        $this->card_string .= "CLASS:".$this->data['class']."\r\n";
        $this->card_string .= "Full Name:".$this->data['display_name']."\r\n";
        $this->card_string .= "First Name:".$this->data['first_name']."\r\n";
        $this->card_string .= "Middle Name:".$this->data['middle_name']."\r\n";
        $this->card_string .= "Last Name:".$this->data['last_name']."\r\n";
        $this->card_string .= "Nick Name:".$this->data['nickname']."\r\n";
        $this->card_string .= "Primary Contact:".$this->data['primary_phone']."\r\n";
        $this->card_string .= "Secondary Contact:".$this->data['secondary_phone']."\r\n";
        $this->card_string .= "Email Id:".$this->data['email_id']."\r\n";        
        $this->card_string .= "END:VCARD\r\n";
    
    }
    
    /** 
     * _build_filename 
     * 
     * Generates a filename from the display name
     * in the card data
     * 
     * @access private 
     * @return string filename 
     */ 
    private function _build_filename()
    {
        $filename = trim($this->data['display_name']);
        $filename = str_replace(" ", "_", $filename);
        $filename .= '.vcf';
        
        return $filename;
    
    }

}
?>