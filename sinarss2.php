<?php

// 新浪微博RSS Feed生成器草根用户版， 作者 @williamlong [ http://www.williamlong.info ]

$username=$_GET["id"]; // request any username with '?id='
if ( empty($username) ) {
	$username='1737203591';    // <-- change this to your username!
} else {
	// Make sure username request is alphanumeric
	$username=ereg_replace("[^A-Za-z0-9]", "", $username);
}
$feedURL='http://v.t.sina.com.cn/widget/widget_blog.php?height=500&skin=wd_01&showpic=1&uid='.$username;

$C = new Collection();
$C->url = $feedURL;
$C->startFlag = '<div id="content_all" class="wgtList">';
$C->endFlag   = '<div id="rolldown" class="wgtMain_bot">';
$C->init();
$C->regExp = "|<p class=\"wgtCell_txt\">(.*)</p>(.*)<a href=\"(.*)\" title=\"\" target=\"_blank\" class=\"link_d\">|Uis";

$C->parse();

header("Content-type:application/xml");

?>

<rss version="2.0">
	<channel>
		<title>rssfeed</title>
		<link>rssfeed</link>
		<description>rssfeed</description>
		<language>zh-cn</language> 
<?php 
for ($i=0;$i<=9;$i++) { 
	$tguid=$C->result[$i][3];
	$tcon=strip_tags($C->result[$i][1]);
if (!empty($tcon)) {
?>
	<item>
		<title><?php //将最常见的特殊字符整理到数组中;
			$table_change = array(
				'&ldquo;'=>'“',
				'&rdquo;' => '”',
				'&hellip;' => '…',
				'&nbsp;' => ' ',
				'&mdash;' => '—',
				'&middot;' => '·',
				'&rarr;' => '→',
				'&amp;gt;' => '>',
				'&amp;quot;' => '"'
			);
			//print_r($table_change);
			$chrkey = false; //定义一个参数，后边用作判断用;
			//遍历数组，判断整理的特殊字符是否在微博中，只要检查到存在特殊字符，立刻设置$chrkey为真，并退出循环；
			foreach ($table_change as  $key=>$val)
			{
				if(strpos($tcon,$key)){
					$chrkey = true;
					break;
				}
			}
			if ($chrkey){//做判断，如果$chrkey为真，则说明存在定义的特殊字符，则输出替换过的微博内容
				echo strtr($tcon,$table_change);
			}elseif(strpos($tcon,'&')){//如果没有定义的特殊字符，那就判断是否存在&，如果有，则替换特殊字符的&和;
				echo strtr($tcon,'&;','()');
			}else{//如果以上都假，那就说明微博没有任何特殊字符，直接输出微博内容。
				$str = mb_substr($tcon)
				echo $tcon;
			}
			?></title>
		<pubDate><?php echo Date('Y-m-j, g:i a'); ?></pubDate>
	</item>

	<?php
}

} ?>
	</channel>
</rss>

<?php

class Collection{
//入口 公有
var $url;       //欲分析的url地址
var $content; //读取到的内容
var $regExp; //要获取部分的正则表达式
var $codeFrom; //原文的编码
var $codeTo; //欲转换的编码
var $timeout;        //等待的时间

var $startFlag;       //文章开始的标志 默认为0       在进行条目时，只对$startFlag 和 $endFlag之间的文字块进行搜索。
var $endFlag;       //文章结束的标志 默认为文章末尾 在进行条目时，只对$startFlag 和 $endFlag之间的文字块进行搜索。  
var $block;        //$startFlag 和 $endFlag之间的文字块
//出口 私有
var $result;       //输出结果

//初始化收集器
function init(){
       if(empty($url))
       $this->getFile();
       $this->convertEncoding();
}
//所需内容
function parse(){
       $this->getBlock();
       preg_match_all($this->regExp, $this->block ,$this->result,PREG_SET_ORDER);
       return $this->block;
}
//错误处理
function error($msg){
       echo $msg;
}
//读取远程网页 如果成功，传回文件；如果失败传回false
function getFile(){
		//使用SAE的用户可以用下面两个替换
		//$f = new SaeFetchurl();
		//$datalines = $f->fetch($this->url);
       $datalines = @file($this->url);
             if(!$datalines){
        $this->error("can't read the url:".$this->url);
                 return false;
       } else {

        //SAE用户请用注释中的语句
		//$importdata = $datalines;
        $importdata = implode('', $datalines); 
        $importdata = str_replace(array ("\r\n", "\r"), "\n", $importdata);                                        

		$this->content = $importdata;
	   }
          }
       //获取所需要的文字块
       function getBlock(){
       if(!empty($this->startFlag))
        $this->block = substr($this->content,strpos($this->content,$this->startFlag));
       if(!empty($this->endFlag))
        $this->block = substr($this->block,0,strpos($this->block,$this->endFlag));
       }
       //内容编码的转换
       function convertEncoding(){
       if(!empty($this->codeTo))
        $this->codeFrom = mb_detect_encoding($this->content);
       //如果给定转换方案，才执行转换。
       if(!empty($this->codeTo))
        $this->content = mb_convert_encoding($this->content,$this->codeTo,$this->codeFrom) or $this->error("can't convert Encoding");
       }
}//end of class

?>