
<style type="text/css">
    .normal,.road,.market,.home,.visit,.visit_pre{
        width: 27px; 
        height: 27px; 
        margin-right: 0px;
        margin-bottom: 0px;
        float: left;
        color:#000000;
        font-size: 10px;
        text-align: center;
    }
    .home{
       background-color: #16a085;
    }
    .market{
       background-color: #c0392b;
    }
    .road{
      background: url(meterial/road.jpg);
      background-size: cover;
    }
    .normal{
        background: url(meterial/bg.jpg);
        background-size: cover;
    }
    .btn{
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .visit{
        
        background: url(meterial/map.png);
        background-size: 100%;
        transition: all 0.1s ease-in;
        background-color: #fbc531;

        
    }
    .visit_pre{
        background: url(meterial/map.png);
        background-size: cover;
        transition: all 0.1s ease-in;
        background-color: #e1b12c;
        filter: brightness(30%);
        filter: blur(5px);
        transition: all 0.2s ease-in;
    }
    .header{
      width: 1360px;
      height: 635px;
    }
</style>


<div class="headerr">

<?php

function set_vertex($x,$y,$home){
  $mark=$home;
  $mark[$x][$y]=1;
  $mark[$x+1][$y+1]=1;
  $mark[$x-1][$y+1]=1;
  $mark[$x+1][$y-1]=1;
  $mark[$x-1][$y-1]=1;
  $mark[$x+1][$y]=1;
  $mark[$x-1][$y]=1;
  $mark[$x][$y+1]=1;
  $mark[$x][$y-1]=1;
return $mark;
}
function set_market_road($x,$y,$road){
    $mark=$road;
    $mark[$x][$y]=1;
    $mark[$x+1][$y]=1;
    $mark[$x-1][$y]=1;
    $mark[$x][$y+1]=1;
    $mark[$x][$y-1]=1;
return $mark;
}

function set_road($x,$y,$vertex,$limit,$road){
 if($vertex=='v_l'){
     for($i=$y; $i<=$y+$limit; $i++)$road[$x][$i]=1;
 }
else if($vertex=='v_u'){
    for($i=$x; $i<=$x+$limit; $i++)$road[$i][$y]=1;
}
return $road;
}

 ?>

<?php

$n=49;

for($i=0; $i<50; $i++){
    for($j=0; $j<50; $j++){
        $home[$i][$j]=0;
        $market[$i][$j]=0;
        $road[$i][$j]=0;
        $center[$i][$j]=0;
    }
}

$home=set_vertex(5,7,$home);

$market_vertex_x=array(5,5,5,11,18,18,18,18,4,11,18);
$market_vertex_y=array(19,31,42,25,7,19,31,42,25,4,25);

for($i=0; $i<11; $i++){
 $a=$market_vertex_x[$i];
 $b=$market_vertex_y[$i];
 $market=set_vertex($a,$b,$market);
 $road=set_market_road($a,$b,$road);
 $center[$a][$b]=1;
}


$road=set_road(8,1,'v_l',46,$road);
$road=set_road(15,1,'v_l',46,$road);
$road=set_road(1,1,'v_l',46,$road);
$road=set_road(21,1,'v_l',46,$road);

$road=set_road(1,1,'v_u',20,$road);
$road=set_road(1,47,'v_u',20,$road);
$road=set_road(1,37,'v_u',7,$road);
$road=set_road(1,13,'v_u',7,$road);

$road=set_road(8,34,'v_u',7,$road);
$road=set_road(8,16,'v_u',7,$road);

$road=set_road(15,13,'v_u',5,$road);
$road=set_road(15,37,'v_u',5,$road);

$road=set_road(6,19,'v_u',1,$road);
$road=set_road(6,31,'v_u',1,$road);
$road=set_road(6,42,'v_u',1,$road);

$road=set_road(9,25,'v_u',1,$road);

$road=set_road(16,42,'v_u',1,$road);
$road=set_road(16,31,'v_u',1,$road);
$road=set_road(16,19,'v_u',1,$road);
$road=set_road(16,7,'v_u',3,$road);

$road=set_road(18,2,'v_l',3,$road);

$road=set_road(5,7,'v_u',2,$road);
$road=set_road(5,2,'v_l',3,$road);
$road=set_road(5,9,'v_l',3,$road);
$road=set_road(2,25,'v_u',1,$road);
$road=set_road(9,4,'v_u',1,$road);
$road=set_road(19,25,'v_u',1,$road);

for($i=0; $i<23; $i++){

for($j=0; $j<$n; $j++){

$btn="";
$onclick="";
$val=0;

if($road[$i][$j]==1){
    $class="road";
    if($home[$i][$j]==1)$class="home";
    if($market[$i][$j]==1)$class="market";
    $val=1;
}
else if($home[$i][$j]==1){
    $class="home";
}
else if($market[$i][$j]==1){
    $class="market";
}    

else $class="normal";

if($center[$i][$j]==1){
    $btn="<button class='btn'></button>";
    $onclick="onclick='fun($i,$j)'";
}

$div_id=$i.",".$j;
 echo "<input type='text' name='' id='road_$div_id' value='$val' hidden>";
 echo "<input type='text' name='' id='s_x' value='-1' hidden>";
 echo "<input type='text' name='' id='s_y' value='-1' hidden>";

$animation="";
if($class=="road"){
  $animation="<div class='dot'></div>";
}

 echo "<div id='$div_id' $onclick class='$class' >$btn</div>";
?>

<?php } } ?>

</div>

<script type="text/javascript">

var dx = new Array();
dx = [0,0,1,-1];
var dy = new Array();
dy = [1,-1,0,0];
var visit = new Array();
var pre_x = new Array();
var pre_y = new Array();
var post_x = new Array();
var post_y = new Array();
var level = new Array();
var visit_road = new Array();
var c=0,c1=0;
for(i=0; i<23; i++){
    visit[i]=new Array(),
    pre_x[i]=new Array(),
    pre_y[i]=new Array();
    level[i]=new Array();
    visit_road[i]=new Array();
    post_x[i]=new Array();
    post_y[i]=new Array();
} 


    function fun(x,y){
       
        res="road_"+String(x)+","+String(y);
        val=document.getElementById(res).value;
        for(i=0; i<4; i++){
            change_color(x+dx[i],y+dy[i]);
        }
        flag=1;

        if(cheikh_sarting_cordinate()==1){
           reset_path();
           s_x=document.getElementById('s_x').value;
           s_y=document.getElementById('s_y').value;
           s_x=parseInt(s_x);
           s_y=parseInt(s_y); 
           t_s_x=s_x;
           t_s_y=s_y;
           s_x=x;
           s_y=y;
           x=t_s_x;
           y=t_s_y;
           engin(x,y,s_x,s_y,"find");
           engin(x,y,s_x,s_y,"set");
           set_cordinate(s_x,s_y);
        }
        else {
          s_x=5;
          s_y=9;
          set_cordinate(x,y);
          res1=engin(x,y,5,9,"find");
          res2=engin(x,y,7,7,"find");
          res3=engin(x,y,5,5,"find");
          console.log("result--------",res,res1,res2);
       
          if(res1<=res2 && res1<=res2)engin(5,8,x,y,"set");
          else if(res2<=res1 && res2<=res3)engin(6,7,x,y,"set");
          else engin(5,6,x,y,"set");
      }
    }


    function cheikh_sarting_cordinate(){
      s_x=document.getElementById('s_x').value;
      s_y=document.getElementById('s_y').value;
      if(s_x==-1 || s_y==-1)return 0;
      return 1;
    }

    function set_cordinate(x,y){
      
      document.getElementById('s_x').value=x;
      document.getElementById('s_y').value=y;

    }

    function engin(x,y,s_x,s_y,per){
        
        find_path_cordinate();
        visit[x][y]=0;
        dfs(s_x,s_y,s_x,s_y,x,y,0);
        if(per=="find")return find_path(x,y,s_x,s_y);
        else {
          console.log(s_x,s_y);
          //set_path(x,y,s_x,s_y);
          set_graph_path(x,y,s_x,s_y);
    }
}
    function change_color(x,y){
        res=String(x)+","+String(y);
        document.getElementById(res).style='background-color: #8e44ad';
    }

    function find_path_cordinate(){
      c=0;
      for(i=0; i<23; i++){
        
        for(j=0; j<49; j++){
            div_id=String(i)+","+String(j);
            res="road_"+div_id;
            visit[i][j]=1;
            level[i][j]=0;
            pre_x[i][j]=-1;
            pre_y[i][j]=-1;

           

            visit_road[i][j]=0;
            val=document.getElementById(res).value;
            if(val==1){
                c++;
                //console.log("visit=",i,j);
                visit[i][j]=0;
            }
        }
      }
    }

    function dfs(x,y,x1,y1,tx,ty,lev){
        
        if(x<0 || y<0 || x>23 || y>49)return;
        if(visit[x][y]==1 && level[x][y]<=lev)return;
        visit[x][y]=1;
        pre_x[x][y]=x1;
        pre_y[x][y]=y1;

        level[x][y]=lev;
        c1++;
        if(x==tx && y==ty)return;
        dfs(x+dx[0],y+dy[0],x,y,tx,ty,lev+1);
        dfs(x+dx[2],y+dy[2],x,y,tx,ty,lev+1);
        dfs(x+dx[3],y+dy[3],x,y,tx,ty,lev+1);
        dfs(x+dx[1],y+dy[1],x,y,tx,ty,lev+1);
    }

    function find_path(x,y,tx,ty){
           if(x==tx && y==ty)return 1;
           x1=pre_x[x][y];
           y1=pre_y[x][y];
          return 1+find_path(x1,y1,tx,ty);
    }

    function set_path(x,y,tx,ty){
           visit_road[x][y]=1;

           x1=pre_x[x][y];
           y1=pre_y[x][y];
           post_x[x1][y1]=x;
           post_y[x1][y1]=y;
           console.log(x,y);
           if(x==tx && y==ty)return;
          set_path(x1,y1,tx,ty);
    }


    function set_graph_path(x,y,tx,ty){
      visit_road[x][y]=1;
      console.log(x,y);
           if(x==tx && y==ty)return;
           console.log(x,y);
           x1=pre_x[x][y];
           y1=pre_y[x][y];
          
           div_id=String(x1)+","+String(y1);
           res="road_"+div_id;
           document.getElementById(div_id).className='visit';

           setTimeout(function(){
               set_graph_path(x1,y1,tx,ty);
            }, 40);
    }

    function reset_path(){
        for(i=0; i<23; i++){
          for(j=0; j<49; j++){
              div_id=String(i)+","+String(j);
              res="road_"+div_id;
              if(visit_road[i][j]==1)
               document.getElementById(div_id).className='visit_pre';
          }      
        }
    }

</script>
