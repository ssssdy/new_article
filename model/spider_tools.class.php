<?php
  session_start();
 //封装成类 开启这些自动抓取文章
  #header("Refresh:30;http://www.test.com:8080");
 class SpiderTools{
     //////////////////////////////////////////////////////////////////////////////////////////////////////////
     /*传入文章ID 解析出文章标题*/
     //////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function getBookNameById($aid){
         //初始化curl
         $ch= curl_init();
         //url
         $url='http://www.motie.com/book/'.$aid;
         if(is_numeric($aid)){
             //正则表达式匹配
             $ru="/<h1\sclass=\"p-title\">\s*<a\shref=\"\/book\/\d+\">(.*)\s*<\/a>\s*<\/h1>/";
         }
         else{
             //<title>丧尸爆发之全家求生路_第一章  丧尸爆发 　为吾友爱乐儿更新~_磨铁</title>
             $ru="/<title>(.*)<\/title>/";
         }
         //设置选项，包括URL
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不自动输出内容
         curl_setopt($ch, CURLOPT_HEADER, 0);//不返回头部信息
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0);
         //执行curl
         $output = curl_exec($ch);
         //错误提示
         if(curl_exec($ch) === false){
             die(curl_error($ch));
         }
         // 检查是否有错误发生
         if(curl_errno($ch)){
             echo 'Curl error: ' . curl_error($ch);
         }
         //释放curl句柄
         curl_close($ch);
         $arr=array();
         preg_match_all($ru,$output,$arr);
         return $arr[1][0];
     }
     //////////////////////////////////////////////////////////////////////////////////////////////////////////
     /*传入文章ID  解析文章内容*/
     //////////////////////////////////////////////////////////////////////////////////////////////////////////
     public  function getBookContextById($aid){
         //开始解析文章
         $ids=array();
         $ids=explode("_",$aid);
         $titleId=trim($ids[0]);
         $aticleId=trim($ids[1]);
         $ch= curl_init();
         $ru="/<div class=\"page-content\">[\s\S]*<pre ondragstart=\"return false\" oncopy=\"return false;\" oncut=\"return false;\" oncontextmenu=\"return false\" class=\"note\" id=\"html_content_\d*\">[\s\S]*(.*)<img src=\"\/ajax\/chapter\/$titleId\/$aticleId\" class=\"hidden\" \/><\/pre>/ui";
         $url='http://www.motie.com/book/'.$aid;
         //正则表达式匹配
         //设置选项，包括URL
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不自动输出内容
         curl_setopt($ch, CURLOPT_HEADER, 0);//不返回头部信息
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0);
         //执行curl
         $output = curl_exec($ch);
         //错误提示
         if(curl_exec($ch) === false){
             die(curl_error($ch));
         }
         // 检查是否有错误发生
         if(curl_errno($ch)){
             echo 'Curl error: ' . curl_error($ch);
         }
         $arr=array();
         $arr2=array();
         preg_match_all($ru,$output,$arr);
         curl_close($ch);
         #var_dump($arr);
         $s=$arr[0][0];
         $s=substr($s,180);
         $arr2=explode("<img",$s);
         return trim($arr2[0]);
     }
     //////////////////////////////////////////////////////////////////////////////////////////////////////////
     /*静态方法 @生成小说文件 可以直接调用 */
     //////////////////////////////////////////////////////////////////////////////////////////////////////////
     public static function createBookById($id){

         if(!is_numeric($id)){
             echo "<br/>INIT BEGIN START WRITE!";
             $st=new self();
             $cons=$st->getBookContextById($id);
             $title=$st->getBookNameById($id);
             $cons=trim($cons);
             $t=explode(" ",$title);
             //构造目录
             $dir=array();
             $dir=explode("_",$t[0]);
             $wzdir=$dir[0];  //书名称 作为目录名称
             $wzchapter=$dir[1]; //第几章
             //创建目录
             $wzdir2=iconv("UTF-8", "GBK", $wzdir);//目录编码 注意这里保留对$wzdir字符串的引用，用来构造文件名，不能用此处，防止二次编码
             if(!file_exists($wzdir2)){
                 mkdir($wzdir2); //创建目录
             }
             //构造文件名
             $wztitle="./".$wzdir."/"."$t[0]".".txt";
             //保证保存的文件名称不是乱码
             $wztitle=iconv("UTF-8", "GBK", $wztitle);
             $f=fopen($wztitle,"w+");
             fwrite($f,$cons);
             echo "<font color='green'>$wzdir </font>".$wzchapter."<font color='red'>写入成功</font>";
             fclose($f);

         }
         else{
             $ids=self::getBookIdsById($id);

             //这里服务器可能会掉线，所以最好用session记录循环
             #for($i=$_SESSION["$id"."_fid"];$i<=count($ids);$_SESSION["$id"."_fid"]++,$i++){

             #self::createBookById($id."_".$ids[$_SESSION["$id"."_fid"]++]);//构造id
             #}

             for($i=$_SESSION["$id"."_fid"];$i<=count($ids);$_SESSION["$id"."_fid"]++,$i++){

                 self::createBookById($id."_".$ids[$i]);//构造id
             }

             #echo "<hr/><hr/><br/><h1>写入工作全部完成</h1>";
             #echo $id."_".$ids[0]."<br/>";
             #var_dump($ids);

         }

     }
     /*
     获取小说的所有ID
     @param $id 文章ID
     @return array;
     */
     public static function getBookIdsById($aid){
         $ch= curl_init();
         $url='http://www.motie.com/book/'.$aid."/chapter";
         //注意这里的?可以获取最少匹配项
         $ru='/[\s\S]*?<li class=\"\" createdate=\"\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}\">[\s\S]*?<a href=\"\/book\/'.$aid.'_(\d*?)\"\s{1}>.*?<\/a>.*?/u';//正则表达式匹配
         //设置选项，包括URL
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不自动输出内容
         curl_setopt($ch, CURLOPT_HEADER, 0);//不返回头部信息
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0);
         //执行curl
         $output = curl_exec($ch);
         // 检查是否有错误发生
         if(curl_errno($ch)){
             echo 'Curl error: ' . curl_error($ch);
         }
         //释放curl句柄
         curl_close($ch);
         $arr=array();
         preg_match_all($ru,$output,$arr,PREG_PATTERN_ORDER);
         return $arr[1];
     }
 }
?>