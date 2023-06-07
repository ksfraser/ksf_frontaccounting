<?php

//20230408 Adding the fputs/fopen/fclose/... into ksf_file
//20230607 this file should be replaced by COMPOSER files ksf_composer_packages/ksf-file/src/*


require_once( 'class.fa_origin.php' );

/*
if( ! defined( 'company_path' ) )
{
	function company_path()
	{
		return "/tmp/";
	}
}
*/

/**//****************************************
* A class to handle file operations.
*
* Assumption is that each file will have its own instance of this class.
* Setting a filename in calling a function overwrites the internal ->filename
* and there is no keeping/reseting old variables.
*********************************************/
class ksf_file extends fa_origin
{
	protected $fp;	//!< @var handle File Pointer
	protected $filename;	//!< @var string name of output file
	protected $tmp_dir;	//!< @var string temporary directory name
	protected $path;	//!<DIR where are the images stored.  default company/X/images...
	protected $mode;
	protected $outstring;	//!<string what to write out (fputs)
	protected $file_contents;	//!<binary data stream - file contents
	protected $bDeleteFile;	//!<bool should we delete the file once we are done with it.
	protected $linecount;	//!<int
	protected $perms;	//!<int File permissions.  Default 0777
	protected $recursive;	//!<bool	Should mkdir recursively create directories to generate path.  Default false
	/**//******************************************************
	*
	*
	***********************************************************/
	function __construct( $filename = "file.txt", $path = null )
	{
		parent::__construct();
		$this->filename = $filename;
		$this->bDeleteFile = false;
		if( null !== $path )
		{
                        $this->path = $path;
		}
		else if( function_exists( company_path ) )
		{
			//We are in an FA module
			$this->path = company_path() . '/images';
		}
                $this->mode = 'r';
		$this->perms = 0777;
		$this->recursive = false;
	}
	/**//******************************************************
	*
	*
	***********************************************************/
	function __destruct()
	{
		if( isset( $this->fp ) )
			$this->close();
		if( $this->bDeleteFile )
		{
			if( file_exists( $this->filename ) )
			{
				unlink( $this->filename );
			}
		}
	}
	/**//******************************************************
	*
	*
	***********************************************************/
	function open()
	{
		$this->validateVariables();
		$this->fopen();
		if( !isset( $this->fp ) )
			throw new Exception( "Unable to set Fileponter when trying to open ". $this->filename );	
	}
        /**//******************************************
         * A function to match the library ones.
         *
         *      As we are matching library functions, our assumption
         *      is that the filename is the complete path.
         *
         **********************************************/
        function fopen( $filename = null, $mode = null )
        {
                if( null !== $filename )
                {
                        $this->set( "filename", $filename );
			$this->set( "path", "" );
                }
                if( null !== $mode )
                {
                        $this->set( "mode", $mode );
                }

                if( isset( $this->filename ) )
                {
			if( strlen( $this->path ) > 1 )
				$filetoopen = this->path . '/' . $this->filename;
			else
				$filetoopen = $this->filename;
                        if ( ($this->fp = fopen( $filetoopen, $this->mode ) ) === FALSE)
                        {
                                throw new Exception( "Can't open file" );
                        }
                }
		return $this->fp;
        }
	/**//******************************************************
	*
	*
	***********************************************************/
	function open_for_write()
	{
		$this->validateVariables();
		$this->set( "mode", "w" );
		$this->fopen();
		if( !isset( $this->fp ) )
			throw new Exception( "Unable to set Fileponter when trying to open ". $this->filename );	
	}
        /**//******************************************
         *
         *
         *
         **********************************************/
        function fclose()
        {
                if( !isset( $this->fp ) )
                        throw new Exception( "Trying to close a Fileponter that isn't set" );
                fclose( $this->fp );
                $this->fp = null;
        }
        /**//******************************************
         *
         *
         *
         **********************************************/
        function fflush()
        {
                if( !isset( $this->fp ) )
                        throw new Exception( "Trying to flush a Fileponter that isn't set" );
                fflush( $this->fp );
        }
	/**//******************************************************
	*
	*
	***********************************************************/
	function close()
	{
		$this->fflush();
		$this->fclose();
	}
	/**//******************************************************
	*
	*
	***********************************************************/
	/*@bool@*/function mkdir( $dir = null, $perms = 0777, $recursive = false )
	{
		$this->validateVariables();
		if( $this->perms <> $perms )
		{
			$this->set( "perms", $perms );
		}
		if( $this->recursive !== $recursive )
		{
			$this->set( "recursive", $recursive );
		}
		if( !$this->pathExists() )
		{
			if( null === $dir )
				$dir = $this->path;
			//mkdir( string $directory, int $permissions = 0777, bool $recursive = false, ?resource $context = null): bool
			mkdir( $dir, $perms, $recursive );
		}
		//Did we succeed?
		return $this->pathExists();
	}
	/**//******************************************************
	*
	*
	***********************************************************/
	/*@bool@*/function make_path()
	{
		return $this->mkdir();
	}
        /**//******************************************
         *
         *
         *
         **********************************************/
        /*@bool@*/function is_dir( $filename = null )
        {
		if( null === $filename )
		{
			$filename = $this->path;
		}
                return is_dir( $filename );
        }
	/**//******************************************************
	*
	*
	***********************************************************/
	/*@bool@*/function pathExists()
	{
                $this->validateVariables();
		return $this->is_dir( $this->path );
	}
	/***************************************************************
	 * Check whether filename is readable
	 *
	 * 
	 * @return bool
	 * *************************************************************/
	/*@bool@*/function is_readable( $filename = null )
	{
		if( null === $filename )
		{
			$filename = $this->path . '/' . $this->filename;
		}
		return is_readable($filename);
	}
	/***************************************************************
	 * Check if filename is writeable
	 *
	 * 
	 * @return bool
	 * *************************************************************/
	/*@bool@*/function is_writeable( $filename = null )
	{
		if( null === $filename )
		{
			$filename = $this->path . '/' . $this->filename;
		}
		return is_writeable($filename);
	}
	/***************************************************************
	 * Check whether the filename is a regular file
	 *
	 * 
	 * @return bool
	 * *************************************************************/
	/*@bool@*/function is_file( $filename = null )
	{
		if( null === $filename )
		{
			$filename = $this->path . '/' . $this->filename;
		}
		return is_file($filename);
	}
	/***************************************************************
	 * Check for the existance of a file
	 *
	 * 
	 * @return bool
	 * *************************************************************/
	/*@bool@*/function file_exists( $filename = null )
	{
		if( null === $filename )
		{
			$filename = $this->path . '/' . $this->filename;
		}
		return file_exists($filename);
	}
	/***************************************************************
	 * Check for the existance of a file
	 *
	 * 
	 * @return bool
	 * *************************************************************/
	/*@bool@*/function fileExists()
	{
		$this->validateVariables();
		return $this->file_exists();
	}
	/**//******************************************************
	*
	*
	***********************************************************/
	function validateVariables()
	{
		if( !isset( $this->path ) )
			throw new Exception( "Path variable not set" );
		if( !isset( $this->filename )  )			
			throw new Exception( "filename variable not set" );
	}
        /**//******************************************
         * Put a string to a filepointer
         *
         * As we are using our internal file pointer, we can NULL
         * the fpo_unused and set outstring, or we can ONLY set
         * fpo_unused.  If fpo_unused isn't a FP/Stream we will
         * assume it's the string if outstring is NULL.
         *
         * If both are NULL we will write the internal ->outstring
         *
         * @var filepointer  UNUSED we will use our internal one!
         * @var string
         *
         **********************************************/
        function fputs( $fpo_unused = "", $outstring = null )
        {
                if( null === $outstring )
                {
                        if(get_resource_type($fpo_unused) !== 'file' AND get_resource_type($fpo_unused) !== 'stream')
                        {
                                //Going to assume the 1 variable is the string to write out
                                if ( is_string($fpo_unused) )
                                {
                                        $this->outstring = $fpo_unused;
                                }
                        }
                }
                else
                if( is_string($outstring) )
                {
                        $this->outstring = $outstring;
                }
                else
                {
                        throw new Exception( "outstring isn't a string." );
                }
                fputs( $this->fp, $this->outstring );
        }
	/**//***************************************************************
	* Use PHP functions to read the file contents entire.
	*
	* @param none uses internal variables
	* @returns none sets internal variables
	********************************************************************/
	function getFileContents()
	{
		if( ! isset( $this->filename ) )
		{
			throw new Exception( "Filename not set.  Can't read an unspecified file", KSF_FIELD_NOT_SET );
		}
		$this->file_contents = file_get_contents($this->filename);
	}
	/**//***************************************************************
	* Grab a filename from the webserver after an upload.
	*
	* @param int id which file (on multi upload) to grab.  Default 0
	* @returns none sets internal variables
	********************************************************************/
	function uploadFileName( $id = 0 )
	{
		if( ! isset( $_FILES ) )
		{
			throw new Exception( "Can't set a filename when one not passed in", KSF_VAR_NOT_SET );
		}
		$this->filename = $_FILES['files']['tmp_name'][$id];
	}
	/**//********************************************************************************
     	* Remove the BOM (Byte Order Mark) from the beginning of the import row if it exists
	*
	* This function came from SuiteCRM ImportFile
	*
	* @param none
     	* @return void
     	*/
    	private function setFpAfterBOM()
    	{
        	if($this->fp === FALSE)
            		return;
        	rewind($this->fp);
        	$bomCheck = fread($this->fp, 3);
        	if($bomCheck != pack("CCC",0xef,0xbb,0xbf)) {
            		rewind($this->fp);
        	}
    	}

	/**//*************************************************************************
     	* Determine the number of lines in this file.
     	*
     	* @return int
     	*/
    	function getNumberOfLinesInfile()
    	{
        	$lineCount = 0;
        	if ($this->fp )
        	{
            		rewind($this->_fp);
            		while( !feof($this->_fp) )
            		{
                		if( fgets($this->_fp) !== FALSE)
                    			$lineCount++;
            		}
            		//Reset the fp to after the bom if applicable.
            		$this->setFpAfterBOM();
        	}
		$this->linecount = $lineCount;
        	return $lineCount;
    	}

}

require_once( 'class.ksf_ui.php' );

/*******************************************************//**
 *
 *
 * Inherits the path of company/images for destination directory
 *
 * **********************************************************/
class ksf_file_upload extends ksf_file
{
	protected $upload_ok;
	protected $files_array;		//!< array List of filenames of files we uploaded
	protected $filepaths_array;	//!< array List of full path filenames of files we uploaded
	protected $ui_class;		//!< class that has the UI screens required for this class to work
	protected $upload_button_name;
	protected $upload_button_label;
	protected $upload_file_field_name;
	protected $b_upload_single_file;
	protected $a_data;		//!< array data returned from file type handler
	function __construct( $filename, $ui_c = null, $upload_file_field_name = "import_files", $b_upload_single_file = true )
	{
		parent::__construct( $filename );
		$this->upload_ok = FALSE;
		$this->files_array = array();
		if( null == $ui_c )
			$this->ui_class = new ksf_ui_class();
		else
			$this->ui_class = $ui_c;
		$this->upload_file_field_name = $upload_file_field_name;
		$this->b_upload_single_file = $b_upload_single_file;
		$this->a_data = array();
	}
	function open()
	{
		$this->validateVariables();
		$this->fp = fopen( $this->path . '/' . $this->filename, 'w' );
		if( !isset( $this->fp ) )
			throw new Exception( "Unable to set Fileponter when trying to open ". $this->filename );	
	}
	function process_files()
	{
		//var_dump( $_FILES );
		/* If $this->b_upload_single_file true, following subarrays don't have 0/1/...
		 * array(1) 
		 * { 
		 * 	["import_files"]=> array(5) 
		 * 	{ 
		 * 		["name"]=> array(2) 
		 * 		{ 
		 * 			[0]=> string(37) "Gator Price list April 2017 Item2.csv" 
		 * 			[1]=> string(32) "Gator Price list April 2017.xlsx" 
		 * 		} 
		 * 		["type"]=> array(2) 
		 * 		{ 
		 * 			[0]=> string(24) "application/octet-stream" 
		 * 			[1]=> string(24) "application/octet-stream" 
		 * 		} 
		 * 		["tmp_name"]=> array(2) 
		 * 		{ 
		 * 			[0]=> string(46) "C:\Bitnami\redmine-3.0.3-0\php\tmp\phpEC9B.tmp" 
		 * 			[1]=> string(46) "C:\Bitnami\redmine-3.0.3-0\php\tmp\phpECAC.tmp" 
		 * 		} 
		 * 		["error"]=> array(2) 
		 * 		{ 
		 * 			[0]=> int(0) 
		 * 			[1]=> int(0) 
		 * 		} 
		 * 		["size"]=> array(2) 
		 * 		{ 
		 * 			[0]=> int(114550) 
		 * 			[1]=> int(32990) 
		 * 		} 
		 * 	} 
		 * }
		 *  */
		if( isset( $_POST['file_type'] ) )
			$type = $_POST['file_type'];
		else
			$type = null;
		if( isset( $_POST[ 'seperator' ] ) )
		 	$seperator = $_POST[ 'seperator' ];
		else
			$seperator = ',';
		if( $this->b_upload_single_file )
		{
			if ( isset( $_FILES[ $this->upload_file_field_name ] ) && $_FILES[ $this->upload_file_field_name ]['name'] != '')
			{
				$filename = $_FILES[ $this->upload_file_field_name ]['tmp_name'];
				$size = $_FILES[ $this->upload_file_field_name ]['size'];
				$error = $_FILES[ $this->upload_file_field_name ]['error'];
				if( !$error )
					$this->a_data[] = $this->process_single_file( $filename, $size, $seperator, $type );
			}
		}
		else
		{
			$filecount = count( $_FILES[ $this->upload_file_field_name ]['tmp_name'] ); //How many files
			for( $count = 0; $count < $filecount; $count++ )
			{
				$filename = $_FILES[ $this->upload_file_field_name ][$count]['tmp_name'];
				$size = $_FILES[ $this->upload_file_field_name ][$count]['size'];
				$error = $_FILES[ $this->upload_file_field_name ][$count]['error'];
				if( !$error )
					$this->a_data[] = $this->process_single_file( $filename, $size, $seperator, $type );
			}
		
		}
		var_dump( $this->a_data );
	}
	function process_single_file( $filename, $size, $separator=',', $type = 'csv' )
	{
		if( $type == 'csv' )
		{
			$fc =  new ksf_file_csv( $filename, $size, $separator );
			$fc->set( 'path', "", false );
			$fc->readcsv_entire();	//sets lines and linecount
			$this->data = array( 'count' => $fc->get( 'linecount' ), 'header' => $fc->get( 'headerline') , 'data' => $fc->get( 'lines' ) );
		}
		return $this->data;
	}
	function upload_form($b_multi=false, $action="", $name="") 
	{

		if( null == $this->ui_class )
			throw new Exception( "UI Class not set" );
		$this->ui_class->div_start('doc_tbl');
		$this->ui_class->form_start( $b_multi, false, $action, $name );
		$this->ui_class->instructions_table();
		$this->ui_class->table_start(TABLESTYLE);
		$this->ui_class->table_header( array(_("Select File(s)"), '') );
		if( $this->b_upload_single_file )
			$multi = "' />";
		else
			$multi = "[]' multiple />";
		label_row(_("Files"), "<input type='file' name='" . $this->upload_file_field_name . $multi);
		start_row();
		label_cell('Upload', "class='label'");
		if( !isset( $this->upload_button_name ) )
			throw new Exception( "Button Name not set", KSF_FIELD_NOT_SET );
		if( !isset( $this->upload_button_label ) )
			throw new Exception( "Button Name not set", KSF_FIELD_NOT_SET );
		submit_cells( $this->upload_button_name, _($this->upload_button_label) );
		end_row();
		$this->ui_class->table_end(1);
		$this->ui_class->form_end();
		div_end();
	}
	function file_put_contents( $content )
	{
		file_put_contents( $this->path . "/" . $this->filename, $content );
		$this->filepaths_array[] = $this->path . "/" . $this->filename;
		$this->files_array[] = $this->filename;
	}
	function copy_file()
	{
		if( isset( $this->fp ) )
			$this->close();
		foreach( $_FILES['files']['name'] as $id=>$fname) 
		{
    			echo "Processing file `$fname`\n";
			$content = file_get_contents($_FILES['files']['tmp_name'][$id]);
			$this->set( "filename", $fname );
			$this->file_put_contents( $content );
		}

	}

}

class ksf_file_csv extends ksf_file
{
	protected $size;
	protected $separator;
	protected $lines = array();	//!<array of arrays once run
	protected $linecount;
	protected $b_header;
	protected $b_skip_header;
	private $grabbed_header;
	protected $headerline;
	protected $enclosure;	//!<char
	protected $escapechar;	//!<char
	protected $fieldcount;	//!<int
	/**//******************************************
	* Setup the CSV reading class file
	*
	* @param string filename
	* @param int size of a line
	* @param char separator what character separates the CSV
	* @param bool is there a header
	* @param bool b_skip_header skip processing the header
	* @return none
	***********************************************/
	function __construct( $filename, $size, $separator, $b_header = false, $b_skip_header = false )
	{
		parent::__construct( $filename );
		$this->size = $size;
		$this->separator = $separator;
		$this->linecount = 0;
		$this->b_header = $b_header;
		$this->b_skip_header = $b_skip_header;
		$this->grabbed_header = false;
		$this->enclosure = null;
		$this->escapechar = null;
		$this->fieldcount = 0;
	}
	/**//**************************************************
	* Read a line from a CSV file
	*
	* @param none
	* @returns array the csv line split up.
	*******************************************************/
	/*@array@*/function readcsv_line()
	{
		if( !isset( $this->fp )  )
			throw new Exception( __CLASS__ . " required field not set: fp" );
		if( ! isset( $this->size )  )
			throw new Exception( __CLASS__ . " required field not set: size" );
		if( ! isset( $this->separator ) )
			throw new Exception( __CLASS__ . " required field not set: separator" );
		if( $this->b_header AND !$this->grabbed_header )
		{
			//fgetcsv( resource $stream, ?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): array|false
			$this->headerline = fgetcsv( $this->fp, $this->size, $this->separator, $this->enclosure, $this->escapechar );
			$this->grabbed_header = true;
		}
		if( ! $this->b_header )
			$this->headerline = '';
		else
		{
		}
		$line = fgetcsv( $this->fp, $this->size, $this->separator );
		if( ! $this->fieldcount )
		{
			$this->set( "fieldcount", count( $line ) );
		}
		$this->linecount++;
		return $line;
	}
	function readcsv_entire()
	{
		if( ! isset( $this->fp ) )
			try {
				$this->open();
			} catch( Exception $e )
			{
				display_notification( $e->getMessage() );
				$this->lines = array();
				return;
			}
		while( $line = $this->readcsv_line() )
		{
			$this->lines[] = $line;
			$this->linecount++;
		}
	}
}

?>
