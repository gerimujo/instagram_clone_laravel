<?php

namespace App\Http\Controllers;

use App\Models\img;
use App\Models\dhena;
use App\Models\hyrje;
use App\Models\posts;
use App\Models\shoqeri;
use App\Models\profilhap;
use App\Models\meszhet;
use Illuminate\Support\Str;
use App\Models\chatlist;

use Illuminate\Http\Request;

class social extends Controller
{
  function rregjistro(Request $request)
  {
    $filepath = $request->file('file')->store('products');

    $img = new img();
    $img->imazh = $filepath;
    $img->save();

  }
  function img()
  {
    $d = img::first();
    return ($d);
  }
  function rregjistrodhena(Request $request)
  {
    $email = $request->input("email");
    $name = $request->input("name");
    $user = $request->input("user");
    $pass = $request->input("pass");

    $ran = rand(1000, 9999);
    $ran1 = (string) $ran;
    $dhen = new dhena();
    $dhen->email = $email;
    $dhen->emri = $name;
    $dhen->user = $name;
    $dhen->pass = $pass;
    $dhen->id = $ran1;
    $dhen->profil = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png";
    $dhen->gjendje = "0";
    $dhen->caption = "Here you put caption";
    $dhen->save();

    return (["procces" => "done"]);


  }
  function hyr1(Request $request)
  {
    $email = $request->input("email");
    $hyr = new hyrje();
    hyrje::truncate();

    $password = $request->input("password");
    if (strpos($email, "@")) {
      $list = dhena::where("email", $email)->first();
      if (isset($list['pass']) && $list['pass'] === $password) {
        $hyrje = new hyrje();
        $hyrje->email = $list['email'];
        $hyrje->emri = $list['emri'];
        $hyrje->user = $list['user'];
        $hyrje->pass = $list['pass'];
        $hyrje->id = $list['id'];
        $hyrje->profil = $list['profil'];
        $hyrje->gjendje = $list['gjendje'];
        $hyrje->caption = $list['caption'];
        $hyrje->save();

        return (["procces" => "done"]);
      } else {
        return (["procces" => "notdone"]);
      }

    } else if (preg_match('/[a-zA-Z]/', $email) === 0) {
      $list = dhena::where("email", $email)->first();
      if (isset($list['pass']) && $list['pass'] === $password) {
        $hyrje = new hyrje();
        $hyrje->email = $list['email'];
        $hyrje->emri = $list['emri'];
        $hyrje->user = $list['user'];
        $hyrje->pass = $list['pass'];
        $hyrje->id = $list['id'];
        $hyrje->profil = $list['profil'];
        $hyrje->gjendje = $list['id'];
        $hyrje->caption = $list['caption'];

        $hyrje->save();

        return (["procces" => "donenumber"]);
      } else {
        return (["procces" => "notdone"]);
      }



    } else {
      $list = dhena::where("user", $email)->first();
      if (isset($list['pass']) && $list['pass'] === $password) {
        $hyrje = new hyrje();
        $hyrje->email = $list['email'];
        $hyrje->emri = $list['emri'];
        $hyrje->user = $list['user'];
        $hyrje->pass = $list['pass'];
        $hyrje->id = $list['id'];
        $hyrje->profil = $list['profil'];
        $hyrje->gjendje = $list['gjendje'];
        $hyrje->caption = $list['caption'];
        $hyrje->save();

        return (["procces" => "done"]);
      } else {
        return (["procces" => "notdone"]);
      }
    }


  }
  function post(Request $request)
  {

    $rand = rand(1000, 9999);
    $rand1 = (string) $rand;
    $filepath = $request->file('file')->store('products');
    $caption = $request->input('caption');

    $hyr = hyrje::first();

    $post = new posts();
    $post->email = $hyr['email'];
    $post->emri = $hyr['emri'];
    $post->user = $hyr['user'];
    $post->pass = $hyr['pass'];
    $post->id = $hyr['id'];
    $post->profil = $hyr['profil'];
    $post->photo = $filepath;
    $post->caption = $caption;
    $post->idpost = $rand1;
    $post->gjendje = $hyr['gjendje'];
    $post->save();

    return (["procces" => "done"]);

  }
  function marrprofil()
  {
    $profili = hyrje::first();
    $user = $profili['user'];
    $fotoprofili = $profili['profil'];

    $postimenr = posts::where("user", $user)->count();
    $folloers = shoqeri::where("user2", $user)->where("marr", "1")->count();
    $following = shoqeri::where("user", $user)->where("marr", "1")->count();
    $caption = $profili['caption'];
    $postimet = posts::where("user", $user)->get();

    return (["caption" => $caption, "fotoprofili" => $fotoprofili, "user" => $user, "numripost" => $postimenr, "folloers" => $folloers, "following" => $following, "postimet" => $postimet]);


  }
  function profiledit()
  {

    $data = hyrje::first();

    return ($data);


  }
  function update(Request $request)
  {

    $hy = new hyrje();
    $dhen = dhena::where("id", $request->input('id'))->first();
    $post = posts::where("id", $request->input('id'))->get();

    $userreal = hyrje::first();

    $shoq = shoqeri::where("user", [$userreal->user])->get();
    $shoq1 = shoqeri::where("user2", [$userreal->user])->get();
$gjendjapara = $userreal['gjendje'];
$gjendjetani = $request->input("gjendje");
$user = $userreal['user'];

if($gjendjapara!=$gjendjetani&&$gjendjetani=="1"){
  shoqeri::where("user2", $user)->update(["marr"=>"1"]);
}





    $type = $request->input('type');
    hyrje::truncate();
    if ($type === "0") {

      if (sizeof($shoq) > 0) {

        shoqeri::where("user", [$userreal->user])->update(["user" => $request->input('user')]);
      }
      if (sizeof($shoq1) > 0) {

        shoqeri::where("user2", [$userreal->user])->update(["user" => $request->input('user')]);
      }
chatlist::where("user",$userreal['user'] )->update(["user"=> $request->input('user')]);
chatlist::where("name",$userreal['emri'] )->update(["name"=> $request->input('emri')]);
chatlist::where("user1",$userreal['user'] )->update(["user1"=> $request->input('user')]);
chatlist::where("name1",$userreal['emri'] )->update(["name1"=> $request->input('emri')]);
meszhet::where("user",$userreal['user'])->update(["user"=>$request->input('user')]);
meszhet::where("name",$userreal['emri'])->update(["name"=>$request->input('emri')]);
meszhet::where("user1",$userreal['user'])->update(["user1"=>$request->input('user')]);     
meszhet::where("name1",$userreal['emri'])->update(["name1"=>$request->input('emri')]);

$hy->email = $request->input('email');
      $hy->emri = $request->input('emri');
      $hy->user = $request->input('user');
      $hy->pass = $request->input('pass');
      $hy->id = $request->input('id');
      $hy->profil = $request->input('profil');
      $hy->gjendje = $request->input("gjendje");
      $hy->caption = $request->input('bio');

      if (sizeof($post) > 0) {


        posts::where("id", $request->input('id'))
          ->update([
            "email" => $request->input('email'),
            "emri" => $request->input('emri'),
            "user" => $request->input('user'),
            "pass" => $request->input('pass'),
            "id" => $request->input('id'),
            "profil" => $request->input('profil'),
            "gjendje" => $request->input("gjendje")
          ]);

      }



      // $dhen->caption = $request->input('bio');


      $dhen->email = $request->input('email');
      $dhen->emri = $request->input('emri');
      $dhen->user = $request->input('user');
      $dhen->pass = $request->input('pass');
      $dhen->id = $request->input('id');
      $dhen->profil = $request->input('profil');
      $dhen->gjendje = $request->input("gjendje");
      $dhen->caption = $request->input('bio');




      $dhen->save();
      $hy->save();
      return (["proces" => "done"]);
    } else if ($type === "1") {
      if (sizeof($shoq) > 0) {

        shoqeri::where("user", [$userreal->user])->update(["user" => $request->input('user')]);
      }
      if (sizeof($shoq1) > 0) {

        shoqeri::where("user2", [$userreal->user])->update(["user" => $request->input('user')]);
      }
chatlist::where("user", $userreal['user'])->update(["photo"=>$request->file('profil')->store('products')]);
chatlist::where("user1", $userreal['user'])->update(["photo1"=>$request->file('profil')->store('products')]);
meszhet::where("user",$userreal['user'])->update(["profil"=>$request->file('profil')->store('products')]);
meszhet::where("user1",$userreal['user'])->update(["profil1"=>$request->file('profil')->store('products')]);
chatlist::where("user",$userreal['user'] )->update(["user"=> $request->input('user')]);
    chatlist::where("name",$userreal['emri'] )->update(["name"=> $request->input('emri')]);
      chatlist::where("user1",$userreal['user'] )->update(["user1"=> $request->input('user')]);
      chatlist::where("name1",$userreal['emri'] )->update(["name1"=> $request->input('emri')]);
      meszhet::where("user",$userreal['user'])->update(["user"=>$request->input('user')]);
      meszhet::where("name",$userreal['emri'])->update(["name"=>$request->input('emri')]);
      meszhet::where("user1",$userreal['user'])->update(["user1"=>$request->input('user')]);     
      meszhet::where("name1",$userreal['emri'])->update(["name1"=>$request->input('emri')]);

      $hy->email = $request->input('email');
      $hy->emri = $request->input('emri');
      $hy->user = $request->input('user');
      $hy->pass = $request->input('pass');
      $hy->id = $request->input('id');
      $hy->profil = $request->file('profil')->store('products');
      $hy->gjendje = $request->input("gjendje");
      $hy->caption = $request->input('bio');

      $dhen->email = $request->input('email');
      $dhen->emri = $request->input('emri');
      $dhen->user = $request->input('user');
      $dhen->pass = $request->input('pass');
      $dhen->id = $request->input('id');
      $dhen->profil = $request->file('profil')->store('products');
      $dhen->gjendje = $request->input("gjendje");
      $dhen->caption = $request->input('bio');
      if (sizeof($post) > 0) {

        posts::where("id", $request->input('id'))
          ->update([
            "email" => $request->input('email'),
            "emri" => $request->input('emri'),
            "user" => $request->input('user'),
            "pass" => $request->input('pass'),
            "id" => $request->input('id'),
            "profil" => $request->file('profil')->store('products'),
            "gjendje" => $request->input("gjendje")
          ]);

      }

      $dhen->save();



      $hy->save();
      return (["proces" => "done"]);
    }


  }
  function profiletmarr()
  {
    $data = hyrje::first();
    $img = $data['profil'];
    if (Str::contains($img, "product") == true && Str::contains($img, "8000") == false) {
      $dhe['profil'] = "http://localhost:8000/" . $img;

    }
    $dhena = dhena::whereNotIn('id', [$data['id']])->get();

    foreach ($dhena as $dhe) {
      if (Str::contains($dhe['profil'], "product") == true && Str::contains($dhe['profil'], "8000") == false) {
        $dhe['profil'] = "http://localhost:8000/" . $dhe['profil'];

      }
    }
    $name = $data['emri'];



    return (["img"=>$img, "data"=>$dhena, "name"=>$name]);
  }
  function profilhapinsert(Request $request)
  {
    profilhap::truncate();
    $dhen = new profilhap();

    $dhen->email = $request->input('email');
    $dhen->emri = $request->input('emri');
    $dhen->user = $request->input('user');
    $dhen->pass = $request->input('pass');
    $dhen->id = $request->input('id');
    $dhen->profil = $request->input('profil');
    $dhen->gjendje = $request->input("gjendje");
    $dhen->caption = $request->input('caption');
    $dhen->save();
    $link = "";
    $un = hyrje::first();   
    $user = $un['user'];
    $profil = profilhap::first();
    $user2 = $profil['user'];
    $gjendjeai = $profil['gjendje'];
    $sttim = shoqeri::where("user", $user)->where("user2", $user2)->get();
    $sttj = shoqeri::where("user", $user2)->where("user2", $user)->get();
    if(sizeof($sttim)>0&&$sttim[0]['marr']=="1"&&$gjendjeai=="0"){
  $link ="http://localhost:3000/profilpublic";
}
if(sizeof($sttim)>0&&$sttim[0]['marr']=="0"&&$gjendjeai=="0"){
  $link ="http://localhost:3000/profilprivat";
}
if(sizeof($sttim)==0&&$gjendjeai=="0"){
  $link ="http://localhost:3000/profilprivat";
}

if($gjendjeai=="1"){
  $link ="http://localhost:3000/profilpublic";

}
    



    return (["proces" => "done", "link"=>$link]);


  }
  function profilprivat()
  {
    $data = profilhap::first();
    $foto = $data['profil'];
    $caption = $data['caption'];
    if (Str::contains($foto, "product") && Str::contains($foto, "8000") == false) {
      $foto = "http://localhost:8000/" + $foto;
    }
    $user = $data['user'];
    $use = hyrje::first();
    $userun = $use['user'];
    $postnumber = posts::where("user", $user)->count();
    $following = shoqeri::where("user", $user)->where("marr", "1")->count();
    $followers = shoqeri::where("user2", $user)->where("marr", "1")->count();
    //follow tag
    //statusi im me te 
    $stim = shoqeri::where("user", $userun)->where("user2", $user)->get();
    $sttij = shoqeri::where("user", $user)->where("user2", $userun)->get();
    $text = "";
    $color = "";
    if (sizeof($stim) == 0 && sizeof($sttij) == 0) {
      $text = "Follow";
      $color = "rgb(0, 149, 246)";
    }

    if (sizeof($stim) > 0 && sizeof($sttij) == 0 && $stim[0]['marr'] == "0") {
      $text = "Requested";
      $color = "rgb(200, 200, 200)";
    }
    if (sizeof($stim) > 0 && sizeof($sttij) > 0 && $stim[0]['marr'] == "0") {
      $text = "Requested";
      $color = "rgb(200, 200, 200)";
    }
    if (sizeof($stim) == 0 && sizeof($sttij) > 0 && $sttij[0]['marr'] == "0") {
      $text = 'Confirm';
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($stim) == 0 && sizeof($sttij) > 0 && $sttij[0]['marr'] == "1") {
      $text = 'Follow Back';
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($stim) > 0 && $stim[0]['marr'] == 0 && sizeof($sttij) > 0 && $sttij[0]['marr'] == 0) {
      $text = 'Confirm';
      $color = "rgb(0, 149, 246)";
    }



    return (["img" => $foto, "user" => $user, "text" => $text, "color" => $color, "posts" => $postnumber, "followers" => $followers, "following" => $following, "caption" => $caption]);
  }
  function shoqeriveprimeprivat(Request $request)
  {
    $dataun = hyrje::first();
    $user = $dataun['user'];
    $data1 = profilhap::first();
    $user2 = $data1['user'];
    $text = $request->input('text');
    $color = $request->input('color');

    if ($text == "Follow" && $color = "rgb(0, 149, 246)") {
      $shoq = new shoqeri();
      $shoq->user = $user;
      $shoq->marr = "0";
      $shoq->user2 = $user2;
      $shoq->save();
      return (["proces" => "done"]);

    }

    if ($text == "Requested" && $color == "rgb(200, 200, 200)") {
      shoqeri::where("user", $user)->where("user2", $user2)->delete();
      return (["proces" => "done"]);
    }


    if ($text == "Confirm" && $color == "rgb(0, 149, 246)") {
      shoqeri::where("user", $user2)->where("user2", $user)->update(["marr" => "1"]);
      // shoqeri::where("user",[$userreal->user])->update(["user"=> $request->input('user')]);
      return (["proces" => "done"]);
    }

    if ($text == "Follow Back" && $color == "rgb(0, 149, 246)") {
      $shoqq = new shoqeri();
      $shoqq->user = $user;
      $shoqq->marr = "0";
      $shoqq->user2 = $user2;
      $shoqq->save();
      return (["proces" => "done"]);
    }

  }
  function profilhapurmarr()
  {
    $profil = profilhap::first();
    $un = hyrje::first();
    $user = $un['user'];

    $foto = $profil['profil'];
    if (Str::contains($foto, "product") && Str::contains($foto, "8000") == false) {
      $foto = "http://localhost:8000/" + $foto;
    }
    $user2 = $profil['user'];
    $postimenr = posts::where('user', $user2)->count();
    $following = shoqeri::where("user", $user2)->where("marr", "1")->count();
    $followers = shoqeri::where("user2", $user2)->where("marr", "1")->count();
    $caption = $profil['user'];
    $posts = posts::where("user", $user2)->get();
    $sttim = shoqeri::where("user", $user)->where("user2", $user2)->get();
    $sttj = shoqeri::where("user", $user2)->where("user2", $user)->get();
    $text = "";
    $color = "";
    if (sizeof($sttim) == 0 && sizeof($sttj) == "0") {
      $text = "Follow";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) > 0 && $sttim[0]['marr'] == "1" && sizeof($sttj) == 0) {
      $text = "Following";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) > 0 && $sttim[0]['marr'] == "1" && sizeof($sttj) > 0 && $sttj[0]['mar'] == "1") {
      $text = "Following";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) == 0 && sizeof($sttj) > 0 && $sttj[0]['marr'] == "0") {
      $text = "Confirm";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) > 0 && $sttim[0]['marr'] == "1" && sizeof($sttj) > 0 && $sttj[0]['marr'] == "0") {
      $text = "Confirm";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) > 0 && $sttim[0]['marr'] == "0" && sizeof($sttj) > 0 && $sttj[0]['marr'] == "0") {
      $text = "Confirm";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) > 0 && $sttim[0]['marr'] == "0" && sizeof($sttj) > 0 && $sttj[0]['marr'] == "1") {
      $text = "Requested";
      $color = "rgb(0, 149, 246)";
    }
    if (sizeof($sttim) == 0 && sizeof($sttj)>0&& $sttj[0]['marr'] == "1") {
      $text = "Follow Back";
      $color = "rgb(0, 149, 246)";
    }
    if(sizeof($sttim)>0&&$sttim[0]['marr']=="1"&&sizeof($sttj)>0&&$sttj[0]['marr']=="1"){
      $text = "Following";
      $color = "rgb(0, 149, 246)";
    }
    return (["sttim"=>$sttim,"sttj"=>$sttj,"fotoprofili" => $foto, "user" => $user2, "posts" => $postimenr, "following" => $following, "followers" => $followers, "postspr" => $posts, "caption" => $caption, "text" => $text, "color" => $color]);
  }function clickpublic(Request $request){
    $text = $request->input('text');
    $un = hyrje::first();   
    $user = $un['user'];
    $profil = profilhap::first();
    $user2 = $profil['user'];
    $gjendjeai = $profil['gjendje'];
    $sttim = shoqeri::where("user", $user)->where("user2", $user2)->get();
    $sttj = shoqeri::where("user", $user2)->where("user2", $user)->get();

$text1 ="";
if($text=="Follow"){
  $sho = new shoqeri();
  $sho->user = $user;
  $sho->marr = "1";
  $sho->user2 = $user2;
  $sho->save();
 return(["proces"=>"done","loaction"=>"http://localhost:3000/profilpublic"]);
}
if($text=="Following"&&$gjendjeai=="0"){
  shoqeri::where("user",$user)->where("user2",$user2)->delete();
  return(["proces"=>"done","loaction"=>"http://localhost:3000/profilprivat"]);
}
if($text=="Following"&&$gjendjeai=="1"){
  shoqeri::where("user",$user)->where("user2",$user2)->delete();
 return(["proces"=>"done","loaction"=>"http://localhost:3000/profilpublic"]);

}
if($text=="Confirm"){
  shoqeri::where("user",$user2)->where("user2",$user)->update(["marr"=>"1"]);
  return(["proces"=>"done","loaction"=>"http://localhost:3000/profilpublic"]);
}
if($text=="Follow Back"){
$sho = new shoqeri();
$sho->user= $user;
$sho->marr = "1";
$sho->user2 = $user2;
$sho->save();

return(["proces"=>"done","loaction"=>"http://localhost:3000/profilpublic"]);
}


  }
  function Homepage(){
    $data = hyrje::first();
    $img = $data['profil'];
    $user = $data['user'];
    if(Str::contains($img, "product")&&Str::contains($img,"8000")==false){
      $img = "http://localhost:8000/". $img;
    }
    $shoqeri = shoqeri::where("user",$user)->where("marr","1")->get();
$array=array();
if(sizeof($shoqeri)>0){
  foreach($shoqeri as $sh){
    $arr = posts::where("user",$sh['user2'])->get();
    array_push($array,$arr);
  
//return(["profil"=>$img,"post"=>$array[0]]);

  }
  $array1=array();
  foreach($array as $a){
   foreach($a as $ss){
    array_push($array1,$ss);

   }
  
//return(["profil"=>$img,"post"=>$array[0]]);

  }


  return(["profil"=>$img,"post"=>$array1]);
}else {
  return(["profil"=>$img]);
    
}



  }function exporenxjerr(){
    $dataun = hyrje::first();
    $id = $dataun['id'];
    $data = posts::where("gjendje","1")->where("id","!=",$id)->get();
   
    return($data);




  }function deletepost(Request $reuqest){
    $id = $reuqest->input('id');
    posts::where("idpost",$id)->delete();
    return(["proces"=>"done"]);

  }function chat(){
  $dataun =  hyrje::first();

  $chat = chatlist::where("user",$dataun['user'])->get();
  $mesazhet = meszhet::where("user",$dataun['user'])->orWhere("user1",$dataun['user'])->get();

  foreach($chat as $ch){
    if(Str::contains($ch['photo'],"product")&&Str::contains($ch['photo'],"8000")==false){
      $ch['photo'] = "http://localhost:8000/".$ch['photo'];
    }
    if(Str::contains($ch['photo1'],"product")&&Str::contains($ch['photo1'],"8000")==false){
      $ch['photo1'] = "http://localhost:8000/".$ch['photo1'];
    }

  }


  $data = hyrje::first();
  $img = $data['profil'];
  if (Str::contains($img, "product") == true && Str::contains($img, "8000") == false) {
    $dhe['profil'] = "http://localhost:8000/" . $img;

  }
  $user = $data['user'];
  $name = $data['emri'];
  
  $dhena = dhena::select(["emri as name1","user as user1","profil as photo1"])->whereNotIn('id', [$data['id']])->get();
  foreach ($dhena as &$dh) {
    if (Str::contains($dh['photo1'], "product") && Str::contains($dh->photo1, "8000")==false) {
        $dh->photo1 = "http://localhost:8000/" . $dh->photo1;
    }
   
   
}





return(["chatlist"=>$chat,"mesazhet"=>$mesazhet, "dhena"=>$dhena, "img"=>$img, "user"=>$user,"name"=>$name]);
  }function sendmesage(Request $request){

$kodi = $request->input('kodi');
if($kodi==0){
  $list = new chatlist;
  $list ->photo = $request->input('profil');
  $list-> user = $request->input('user');
  $list ->name = $request->input('name');
  $list ->photo1 = $request->input('profil1');
  $list-> user1 = $request->input('user1');
  $list ->name1 = $request->input('name1');
  $list->save();

  $lis = new chatlist;
  $lis ->photo =   $request->input('profil1');
  $lis-> user = $request->input('user1');
  $lis ->name = $request->input('name1');
  $lis ->photo1 = $request->input('profil');
  $lis-> user1 = $request->input('user');
  $lis ->name1 = $request->input('name');
  $lis->save();

}
  /*  
    data.append("profil",ptoprofiliun);
    data.append("user",userune);
    data.append("name", nameun);
    data.append("mesazhi",text1);
    data.append("profil1",fotovhatopen);
    data.append("user1",userai );
    data.append("name1", name);
    data.append("kodi", inbox.length)
*/
$mesazh =  new meszhet();
$mesazh->profil = $request->input('profil');
$mesazh->user = $request->input('user');
$mesazh->name = $request->input('name');
$mesazh->mesazhi = $request->input('mesazhi');

$mesazh->profil1 = $request->input('profil1');
$mesazh->user1 = $request->input('user1');
$mesazh->name1 = $request->input('name1');
$mesazh->kodi = $request->input('kodi');
$mesazh->save();


    

return(["proces"=>"done"]);


  }



}