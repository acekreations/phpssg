<?php
    // check if build directory exists
    if (!file_exists('build')) {
        mkdir('build');
    } else {
        // remove all files and folders from build directory
        $dir = 'build';
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                    RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }

    // get all files from src directory
    $dir_iterator = new RecursiveDirectoryIterator("src/");
    $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::CHILD_FIRST);
    $files = array();
    foreach ($iterator as $file) {
        // check if file is php file
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            array_push($files, $file);
        }
    }

    // for each file in files array generate html file in build directory
    foreach ($files as $file) {
        $file_path = explode("/", $file->getPathname());
        $file_name = $file_path[count($file_path) - 1];
        $file_name = explode(".", $file_name)[0];
        array_pop($file_path);
        array_shift($file_path);
        $file_path = join('/', $file_path);

        // skip any files that start with an underscore
        if($file_name[0] !== '_'){
            if(strlen($file_path) > 0){
                if (!is_dir('build/' . $file_path))
                    {
                        mkdir('build/' . $file_path, 0755, true);
                    }
            }
            $file_name = basename($file_name, '.php');
            if(strlen($file_path) > 0){
                $output_file_name = "build/" . $file_path . "/" . $file_name . ".html";
            } else {
                $output_file_name = "build/" . $file_name . ".html";
            }
            ob_start();
            include($file);
            $output_file = fopen($output_file_name, 'w');
            fwrite($output_file, ob_get_contents());
            fclose($output_file);
            ob_end_flush();
        }
    }


    

?>