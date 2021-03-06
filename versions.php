<?php
/**
 *
 * This file is part of Open Library System.
 * Copyright © 2010, Dansk Bibliotekscenter a/s,
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
 *  Different version of a service should be in sub-directories like
 *     .../myWebService/
 *     .../myWebService/1.0/
 *     .../myWebService/1.2/
 *     .../myWebService/1.3/
 *
 *  Only sub-directories with a NEWS.html file is exposed. Directories are
 *  sorted chronologically reverse order of the NEWS.html mdate
 *
 *  Fill info.html with the text you will expose and put a %s where the version info should be
 * 
 *  Fill line.html with _DIR_ where the version/directory should go and _DATE_ if you 
 *  would like to expose the date of the NEWS.html file in the version
 *
 */

$ignore = array("service" => TRUE);

$info = read_info();

$line = read_line();

if ($dp = opendir('.')) {
  while ($file = readdir($dp)) {
    if (is_dir($file) && empty($ignore[$file]) && $file[0] <> '.' && is_file($file.'/NEWS.html')) {
      $dirs[$file] = filemtime($file.'/NEWS.html');
    }
  }
}

// sort according to timestamp
arsort($dirs, SORT_NUMERIC);

foreach ($dirs as $dir => $sort) {
  $vers .= str_replace('_DATE_', date('F j Y', $sort), str_replace('_DIR_', $dir, $line));
}
printf($info, $vers);

/* ------------------------------------------------ */

function read_info() {
  if ($fp = @ fopen('info.html', 'r')) {
    $info = fread($fp, filesize('info.html'));
    fclose($fp);
  } 
  else {
    $info = "This service expose the following versions:<br/>%s";
  }
  return $info;
}

function read_line() {
  if ($fp = @ fopen('line.html', 'r')) {
    $line = fread($fp, filesize('line.html'));
    fclose($fp);
  } 
  else {
    $line = '<a href="_DIR_">_DIR_</a> <a href="_DIR_/?wsdl">wsdl</a> <a href="_DIR_/NEWS.html">NEWS.html</a> at _DATE_' . PHP_EOL;
  }
  return $line;
}
?>
