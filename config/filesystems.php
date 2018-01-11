<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],
    ],

    'mimeType' => [

	    'video' => [
		    'video/3gpp'                        => ['3gp'],
		    'video/mp4'                         => ['mp4', 'mp4v', 'mpg4',],
		    'video/mpeg'                        => ['mpeg', 'mpg', 'mpe', 'm1v', 'm2v',],
		    'video/x-f4v'                       => ['f4v'],
		    'video/x-flv'                       => ['flv'],
		    'video/x-m4v'                       => ['m4v'],
		    'video/x-matroska'                  => ['mkv', 'mk3d', 'mks',],
		    'video/x-ms-vob'                    => ['vob'],
		    'video/x-ms-wmv'                    => ['wmv'],
		    'video/x-msvideo'                   => ['avi'],
		    'application/vnd.rn-realmedia'	    => ['rm'],
		    'application/vnd.rn-realmedia-vbr'  => ['rmvb'],
	    ],

	    'text' => [
		    'text/css'               => ['css'],
		    'text/csv'               => ['csv'],
		    'text/html'              => ['html','tm',],
		    'text/plain'             => ['txt','text','conf','def','list','log','in',],
		    'text/x-c'               => ['c','cc','cxx','cpp','h','hh',],
		    'text/x-java-source'     => ['java'],
		    'application/javascript' => ['js'],
		    'application/json'		 => ['json'],
		    'application/wsdl+xml'	 => ['wsdl'],
		    'application/x-sh'		 => ['sh'],
		    'application/xml'		 => ['xml, xsl'],
		    'application/x-sql'		 => ['sql'],
	    ],

	    'image' => [
		    'image/jpeg'                => ['jpeg','jpg','jpe',],
		    'image/png'                 => ['png'],
		    'image/svg+xml'             => ['svg','svgz',],
		    'image/tiff'                => ['tiff','tif',],
		    'image/vnd.adobe.photoshop' => ['psd'],
		    'image/x-icon'              => ['ico'],
		    'image/bmp'                 => ['bmp'],
	    ],

	    'font' => [
		    'font/collection' => ['ttc'],
		    'font/otf'        => ['otf'],
		    'font/ttf'        => ['ttf'],
		    'font/woff'       => ['woff'],
		    'font/woff2'      => ['woff2'],
	    ],

	    'audio' => [
		    'audio/mp4'        => ['m4a','mp4a',],
		    'audio/mpeg'       => ['mpga','mp2','mp2a','mp3','m2a','m3a',],
		    'audio/ogg'        => ['oga','ogg','spx',],
		    'audio/x-aac'      => ['aac'],
		    'audio/x-aiff'     => ['aif','aiff','aifc',],
		    'audio/x-caf'      => ['caf'],
		    'audio/x-flac'     => ['flac'],
		    'audio/x-matroska' => ['mka'],
		    'audio/x-mpegurl'  => ['m3u'],
		    'audio/x-ms-wax'   => ['wax'],
		    'audio/x-ms-wma'   => ['wma'],
		    'audio/x-wav'      => ['wav'],
	    ],

	    'document' => [
		    'application/msword'            => ['doc', 'dot'],
		    'application/vnd.ms-excel'		=> ['xls', 'xlm', 'xla', 'xlc', 'xlt', 'xlw'],
		    'application/pdf'               => ['pdf'],
		    'application/vnd.ms-htmlhelp'   => ['chm'],
		    'application/vnd.ms-powerpoint' => ['ppt', 'pps', 'pot'],
		    'application/vnd.ms-works'      => ['wps', 'wks', 'wcm', 'wdb'],
		    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => ['docx'],
		    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => ['xlsx'],
		    'application/vnd.openxmlformats-officedocument.wordprocessingml.template'   => ['dotx'],
		    'application/vnd.openxmlformats-officedocument.spreadsheetml.template'      => ['xltx'],
		    'application/vnd.openxmlformats-officedocument.presentationml.template'     => ['potx'],
		    'application/vnd.openxmlformats-officedocument.presentationml.slideshow'    => ['ppsx'],
		    'application/vnd.openxmlformats-officedocument.presentationml.presentation' => ['pptx'],
	    ],

	    'other' => [
		    'application/epub+zip'                    => ['epub'],
		    'application/octet-stream'                => ['bin', 'dms', 'lrf', 'mar', 'so', 'dist', 'distz', 'pkg', 'bpk', 'dump', 'elc'],
		    'application/vnd.android.package-archive' => ['apk'],
		    'application/vnd.apple.installer+xml'     => ['mpkg'],
		    'application/vnd.apple.mpegurl'           => ['m3u8'],
		    'application/vnd.ms-cab-compressed'       => ['cab'],
		    'application/x-7z-compressed'             => ['7z'],
		    'application/x-bzip'                      => ['bz'],
		    'application/x-bzip2'                     => ['bz2', 'boz'],
		    'application/x-cbr'                       => ['cbr', 'cba', 'cbt', 'cbz', 'cb7'],
		    'application/x-mobipocket-ebook'          => ['prc', 'mobi'],
		    'application/x-msdownload'                => ['exe', 'dll', 'com', 'bat', 'msi'],
		    'application/x-rar-compressed'            => ['rar'],
		    'application/zip'                         => ['zip'],
	    ],
    ],

];
