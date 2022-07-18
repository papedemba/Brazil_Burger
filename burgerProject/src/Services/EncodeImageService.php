<?php

 namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class EncodeImageService
{
    
    public function getAttributes(Request $request){
        $donnee = $request->getContent();
        $attributes = [];
        //eclater la chaine
        $data = preg_split("/form-data; /", $donnee);
        //suppression du premier élément
        unset($data[0]);
        foreach ($data as $item){
            $data2 = preg_split("/\r\n/", $item);
            array_pop($data2);
            array_pop($data2);
            $key = explode('"', $data2[0]);
            $key = $key[1];
            $attributes[$key] = end($data2);
        }
        return $attributes;
    }
    
   public function EncoderImage(Request $request, string $fileName = null)
   {
      $row = $request->getContent();
      $delimitor = "multipart/form-data; boundary=";
      $boundary = "--".explode($delimitor, $request->headers->get("content-type"))[1];
      $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$row);
      //dd($elements);
      $tabElements = explode("\r\n\r\n", $elements);
      //dd($tabElements);
      $data = [];
      for ($i = 0; isset($tabElements[$i+1]); $i++)
      {
          $key = str_replace(["\r\n",' "','"'],'',$tabElements[$i]);
          //dd($key);
          if (strchr($key, $fileName))
          {
              $file = fopen('php://memory', 'r+');
              fwrite($file, $tabElements[$i+1]);
              rewind($file);
              $data[$fileName] = $file;
          }else {
              $val = str_replace(["\r\n",'--'], '', $tabElements[$i+1]);
              $data[$key] = $val;
          }
      }
     //dd($data);
      return $data;
  }
 
}