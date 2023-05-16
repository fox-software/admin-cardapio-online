<?php

namespace App\Libraries;

use Aws\S3\S3Client;

class AwsS3
{
  public function store($file)
  {
    $s3config = [
      'region'      => getenv("AWS_REGION"),
      'version'     => 'latest',
      'credentials' => [
        'key'    => getenv("AWS_ACCESS_KEY_ID"),
        'secret' => getenv("AWS_SECRET_ACCESS_KEY")
      ]
    ];

    $s3 = new S3Client($s3config);

    $key = date("Y-m-d_H-i-s") . '_' . $file['name'];

    $result = $s3->putObject(
      [
        'Bucket'     => getenv("AWS_BUCKET"),
        'Key'        => $key,
        'SourceFile' => $file['tmp_name'],
        'ACL'        => 'public-read'
      ]
    );

    return $result['ObjectURL'];
  }
}
