<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 28.04.2021
 * Time: 16:32
 */

namespace ch28;

require_once("ApplicationBase.php");
require_once ("chapter_29/DirectoryInfo.php");
require_once ("chapter_29/ArrayData.php");
require_once ("chapter_29/ExtensionIterator.php");

use core\ApplicationBase;
use fs\ArrayData;
use fs\DirectoryInfo;
use fs\ExtensionIterator;


class ApplicationChapter_28 extends ApplicationBase
{
    # Traits ------------------------------------------------------

    # Init ------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    # Run ------------------------------------------------------

    public function Exec()
    {
        //parent::Exec(); // TODO: Change the autogenerated stub
        $this->StaticCallTest();
    }

    # Methods ------------------------------------------------------

    public function DateTimeTest()
    {
        self::PrintHeader("DateTime Test");

        $dt = new \DateTime("2016-05-18 ");
        $info = $dt->format("Y.m.d H:i:s");

        $newdt = new \DateTime();
        $diff = $newdt->diff($dt);

        self::WriteLine("Current date is: $info");
        self::WriteLine("Datetime interval is: ".$diff->format("%Y-%m-%d %H:%S"));

        $d = $newdt->sub(new \DateInterval("P4Y2M1DT10H23M20S"));
        self::WriteLine("Another time period: ".$d->format("Y.m.d H:i:s"));

        self::PrintHeader("Dates period each 3 weeks");
        $gen = new \DatePeriod($d, new \DateInterval("P3W"), 5);

        foreach ($gen as $value)
        {
            self::WriteLine("Period: ".$value->format("Y.m.d  H:i:s"));
        }
    }

    public function IteratorTest()
    {
        self::PrintHeader("Iterator Test");

        $dir = new DirectoryInfo("C:/Windows");

        foreach ($dir as $key => $value)
        {
            if( $value instanceof DirectoryInfo)
            {
                self::WriteLine($key." => ".$value->getPath());
            }
            else
            {
                self::WriteLine($key." => ".$value);
            }

        }
    }

    public function ArrayTest()
    {
        self::WriteLine("Array Access Test");

        $arr = new ArrayData();
        $arr['test'] = <<<TEST
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ad architecto at dolorem earum excepturi, 
fugiat illum laudantium mollitia odio quaerat, 
quas quisquam quo reiciendis, sunt tenetur vel veniam voluptatum.
TEST;
        $arr['number'] = random_int(100, 200);
        $arr['wrong'] = 0xff00fff;
        unset($arr['wrong']);

        $m = &$arr->__data();

        foreach ($m as $k => $item) {
            self::WriteLine("Array Data $k => $item");
        }

    }

    public function DirIteratorTest()
    {
        self::WriteLine("Directory Iterator Test");

        $dir = new \DirectoryIterator("C:/Windows");

        foreach ($dir as $d)
        {
            self::WriteLine("File: ".$d->getFilename());
            self::WriteLine("Ext: ".$d->getExtension());
            self::WriteLine("Path: ".$d->getPathname());
            self::WriteLine("Size: ".$d->getSize());
            self::WriteLine(" ");
        }
    }

    public function ExtIterator()
    {
        $dir = new \DirectoryIterator("C:/Windows");
        $ext = new ExtensionIterator($dir, "xml");

        self::WriteLine("Extension Iterator");

        foreach ($ext as $item) {
            self::WriteLine($item);
            self::WriteLine("");
        }
    }

    public function LimitIteratorTest()
    {
        self::PrintHeader4("Section Iterator");

        $iter = new \LimitIterator(new ExtensionIterator(new \DirectoryIterator("C:/Windows"), "dll"), 0, 3);

        foreach ($iter as $items)
        {
            self::WriteLine($items);
            self::WriteLine("----------");
        }
    }

    public function StaticCallTest()
    {
        call_user_func(array('core\ApplicationBase', 'PrintHeader4'), "Call Static Function Through Function");
    }
}