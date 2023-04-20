<?php

require_once( 'class.origin.php' );
require_once( 'defines.inc.php' );


class ksf_file extends origin
{
	protected $fp;	//!< @var handle File Pointer
	protected $filename;	//!< @var string name of output file
	protected $tmp_dir;	//!< @var string temporary directory name
	protected $path;	//!<DIR where are the images stored.  default company/X/images...
	protected $filesize;	//!<int
	protected $filepath;	//!<string full path
	protected $filecontents;	//!<binary file contents.
	/**//*****************************************************
	* Construct the File handling class
	*
	* @param string filename
	* @param string (optional)path
	* @return none sets internal variables.
	***********************************************************/
	function __construct( $filename = "file.txt", $path = null )
	{
		parent::__construct();
		$this->filename = $filename;
/*
 *This has implications for ->open()
		if( null !== $path )	
		{
*/
			$this->path = $path;
/*
		}
		else
		{
			$path = dirname();
		}
*/
		if( strlen( $this->path ) > 1 )
			$this->filepath = $this->path . '/' . $this->filename;
		else
			$this->filepath = $this->filename;
		$this->filesize = filesize( $this->filepath );
	}
	function __destruct()
	{
		if( isset( $this->fp ) )
			$this->close();
	}
	/**//*****************************************************
	* Open the file
	*
	* @param none uses internal variables.
	* @return none sets internal variables.
	***********************************************************/
	function open()
	{
		$this->validateVariables();
		$this->fp = fopen( $this->filepath, 'r' );
		if( !isset( $this->fp ) )
			throw new Exception( "Unable to set Fileponter when trying to open ". $this->filename, KSF_FILE_OPEN_FAILED );	
	}
	function open_for_write()
	{
		$this->validateVariables();
		$this->fp = fopen( $this->filepath, 'w' );
		if( !isset( $this->fp ) )
			throw new Exception( "Unable to set Fileponter when trying to open ". $this->filename, KSF_FILE_OPEN_FAILED );	
	}
	function close()
	{
		if( !isset( $this->fp ) )
			throw new Exception( "Trying to close a Fileponter that isn't set", KSF_FIELD_NOT_SET );
		fflush( $this->fp );
		fclose( $this->fp );
		$this->fp = null;
	}
	/*@bool@*/function make_path()
	{
		$this->validateVariables();
		if( !$this->pathExists() )
			mkdir( $this->path );
		//Did we succeed?
		return $this->pathExists();
	}
	/*@bool@*/function pathExists()
	{
		$this->validateVariables();	
		return is_dir( $this->path );
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
		return file_exists( $this->path . '/' . $this->filename );
	}
	function validateVariables()
	{
		if( !isset( $this->path ) )
			throw new Exception( "Path variable not set", KSF_FIELD_NOT_SET );
		if( !isset( $this->filename )  )									
			throw new Exception( "filename variable not set", KSF_FIELD_NOT_SET );
	}
	/***************************************************************
	 * Check for the existance of a file
	 *
	 * 
	 * @return string file contents
	 * *************************************************************/
	function get_all_contents()
	{
		if( ! isset( $this->fp ) )
		{
			throw new Exception( "File Pointer not set, can't read", KSF_FILED_NOT_SET );
		}
		if( ! isset( $this->filesize ) )
		{
			throw new Exception( "File Size not setd", KSF_FILED_NOT_SET );
		}
		$this->filecontents = fread( $this->fp, $this->filesize );
		return $this->filecontents;
	}
/*
	fwrite() - Binary-safe file write
	fopen() - Opens file or URL
	fsockopen() - Open Internet or Unix domain socket connection
	popen() - Opens process file pointer
	fgets() - Gets line from file pointer
	fgetss() - Gets line from file pointer and strip HTML tags
	fscanf() - Parses input from a file according to a format
	file() - Reads entire file into an array
	fpassthru() - Output all remaining data on a file pointer
	fseek() - Seeks on a file pointer
	ftell() - Returns the current position of the file read/write pointer
	rewind() - Rewind the position of a file pointer
	unpack() - Unpack data from binary string
	fread() - Binary-safe file read
	readfile() - Outputs a file
	file_put_contents() - Write data to a file
	stream_get_contents() - Reads remainder of a stream into a string
	stream_context_create() - Creates a stream context
	$http_response_header
*/
}
