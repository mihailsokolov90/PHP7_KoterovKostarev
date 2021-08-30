<?php

namespace core;

require_once "ApplicationBase.php";


class ApplicationChapter_32 extends ApplicationBase
{
    # -------------------------------------------------------------------
    # INIT
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct(); // TODO: Change the autogenerated stub
    }

    # -------------------------------------------------------------------
    # Execution Interface

    public function Exec()
    {
        self::SockTesting();
    }

    # -------------------------------------------------------------------
    # Tests Methods
    /**
     * @author Mikle
     * @api - Make some functions
     */
    public function StreamFunctions()
    {
        self::PrintHeader4("Stream function");

        $Opts = [ 'http' => [ "method" => 'GET', 'header' => 'Content-type: text/html; charset: UTF-8' ] ];

        $contents = file_get_contents("http://php.net", false, stream_context_create($Opts));

        self::WritePreData( htmlentities($contents) );
    }

    public function SendPostForm()
    {

    }

    public function ProcessPostForm()
    {
        self::PrintHeader4("Process POST data");

        if( isset($_POST['name']) )
        {
            $form = [];
            $form[] = $_POST['name'];
            $form[] = $_POST['passwd'];

            $str = implode(" ", $form);

            self::WriteLine($str);
        }
        else
        {
            self::PrintHeader("There is no data", 6);
        }
    }

    public final function SockTesting()
    {
        self::PrintHeader4("Socket functions test");

        $err_code = 0;
        $err_msg = "no";
        $fd = fsockopen('localhost', 80, $err_code, $err_msg, 10);

        if( !$fd )
        {
            self::WriteLine("Connection error [$err_code]: ".$err_msg);
            return;
        }

        fputs($fd, 'GET /index.html HTTP/1.0\n');
        fputs($fd, 'Host: localhost\n');
        fputs($fd, 'User-agent: Mozilla 6.0\n');
        fputs($fd, 'Connection: close\n');
        fputs($fd, '\n');

        $data = [];
        while( !feof($fd) )
        {
            $str =  fgets($fd, 1000);
            if( $str ) $data[] = htmlspecialchars( $str );
        }

        fclose($fd);

        self::WritePreData( implode("\n", $data) );
    }
}