<?php
namespace Treinetic\ImageArtist\lib\Text\Write;
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/12/17
 * Time: 10:01 AM
 */


/*
 *
 * */
interface WritingStrategy
{
    public function write();

    public function setWriter(\Treinetic\ImageArtist\lib\Text\TextWriter $textWriter);
}