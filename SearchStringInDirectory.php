<?php
/**
 * PHP Search String in folder
 *
 * @package SearchStringInDirectory
 * @author  phutv <jupro123@gmail.com>
 * @access  public
 */
class SearchStringInDirectory
{
    var $files;
    var $directory = '/jquery-upload-file/server/php/files/';

    var $searchOptions = '-Ril';
    var $command = 'grep';
    var $ignoreFile = array('.', '..', '.gitignore', '.htaccess');

    var $searchString = null;


    function __construct($root = null)
    {
        $this->setDirectory($root);
    }

    function createSearchCommand()
    {

        if ($this->searchString == null) {
            $string = '';
        }
        else{
            $string = $this->searchString;
        }
        return $this->command." ".$this->searchOptions." '".$string."' ".$this->directory;
    }

    function isWindows()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        }
    }

    function isLinux()
    {
        if (PHP_OS === 'Linux') {
            return true;
        }
    }

    function setDirectory($dir = null)
    {
        
        if (!is_dir($dir)) {
            $dir = getcwd().$dir;
            if (!is_dir($dir)) {
                $dir = getcwd();
            }
        }
        $dir = str_replace('\\', '/', $dir);
        $this->directory = $dir;
    }

    function search($string = null)
    {
        $this->searchString = trim($string);
        $command = $this->createSearchCommand();
        return $this->exec($command);
    }
    function exec($command)
    {
        $output = @shell_exec("$command");
        if ($output) {
            $output = array_filter(explode("\n", $output));
            $this->ignore($output);
        }
        return $this->files;
    }
    function ignore($output)
    {
        if (count($this->ignoreFile) && count($output)) { 
            foreach ($output as $key => $link) {
                if (!in_array(basename($link), $this->ignoreFile)) {
                    $file = pathinfo($link);
                    $file['filepath'] = ($link);
                    $file['modified'] = date('F d Y, H:i:s', filemtime($link));
                    $this->files[] = (object)$file;
                }
            }
        }
    }
}
?>