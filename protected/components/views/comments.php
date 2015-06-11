<ul>
<?php 
$comments = array(array('details'=>"aaa bbb ccc ddd"), array('details'=>"ppp qqq rrr zzz"));//$this->getComments();
 
foreach($comments as $comment)
{
    echo "<li> {$comment['details']}</li>";
}
?>
</ul>