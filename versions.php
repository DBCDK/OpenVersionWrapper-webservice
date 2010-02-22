<?php
/**
 *
 * This file is part of Open Library System.
 * Copyright © 2009, Dansk Bibliotekscenter a/s,
 * Tempovej 7-11, DK-2750 Ballerup, Denmark. CVR: 15149043
 *
 * Open Library System is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Open Library System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Open Library System.  If not, see <http://www.gnu.org/licenses/>.
*/


/** \brief Show versions
 *
 *  Fill info.html with the text you will expose and put a %s where the version info should be
 * 
 *  Fill line.html with _DIR_ where the version/directory should go and _DATE_ if you 
 *  would like to expose the date of the NEWS.html file in the version
 *
 */


  if ($fp = fopen("info.html", "r")) {
    $info = fread($fp, filesize("info.html"));
    fclose($fp);
  } else
    $info = "This service expose the following versions:<br/>%s";

  if ($fp = fopen("line.html", "r")) {
    $line = fread($fp, filesize("line.html"));
    fclose($fp);
  } else
    $line = '<a href="_DIR_">_DIR_</a> &nbsp; <a href="_DIR_/NEWS.html">_DIR_/NEWS</a><br/>';

  if ($dp = opendir('.'))
    while ($file = readdir($dp))
      if (is_dir($file) && $file[0] <> '.' && is_file($file.'/NEWS.html')) 
        $vers .= str_replace("_DATE_", date("F j Y", filemtime($file.'/NEWS.html')), str_replace("_DIR_", $file, $line));

  printf($info, $vers);
?>