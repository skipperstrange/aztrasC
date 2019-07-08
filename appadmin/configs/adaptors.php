<?php
        $openADfile = fopen('../'.LIB_PATH.'adaptorsLoader.php', 'r');
        $adFolders = fileSystem::folderStructure('../' . ADAPTORS_PATH);

        $adaptorFolder = $_POST['adaptors'];

        if ($adaptorFolder) {
            $content = "<?php
";

            $line;
            $i = 0;
            foreach ($adaptorFolder as $folder => $adaptor):
                $adName = $folder;

                foreach ($adaptorFolder[$folder] as $adfile => $status):
                    if ($folder != 'adaptors') {
                        $line .= 'load' . $folder . "Adaptor('$adfile');
";
                        $i++;
                    } else {
                        $line .= "autoLoadAdaptor('$adfile');
";
                        $i++;
                    }
                endforeach;
            endforeach;
            $content .= $line;
            $content .= '
?>';
            if (FileSystem::createFile('adaptorsLoader.php', '../'.LIB_PATH, $content, 1, 'w')) {
                flash_notice('Successfully Modified adaptor list. '.$i." Adaptor(s) loaded.");
                admin_redirect_to('', 'adaptors');
            }
        } else {

            if (FileSystem::createFile('adaptorsLoader.php', '../'.LIB_PATH, $content, 1, 'w')) {
                flash_notice('Successfully Modified adaptor list.'.$i." Adaptor(s) loaded.");
                admin_redirect_to('', 'adaptors');
            }
        }
