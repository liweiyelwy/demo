  //图片提交
    public function upload__img(){
      $shop_id=$_SESSION['ad_shop_id'];
      $img=$_POST['img'];
      $delimiter=strpos($img,',');
      $head=substr($img,0,$delimiter);
      $suf;
      if(strpos($head,'png')){
        $suf='png';
      }elseif (strpos($head,'jpg')) {
        $suf='jpg';
      }elseif (strpos($head,'jpeg')) {
        $suf='jpeg';
      }else{
        $this->ajaxReturn(array('code'=>'1','msg'=>'图片有误'));
      }
      $base64=substr($img,$delimiter+1);
      $img_name=date('YmdHis');
      $a=file_put_contents('./Public/goods_img/'.$img_name.'.'.$suf,base64_decode($base64));
      if($a){
        $shop_old_img=M('shop')->where(array('shop_id'=>$shop_id))->find()['shop_img'];
        unlink('.'.$shop_old_img);
        $img_url='/Public/goods_img/'.$img_name.'.'.$suf;
        $r=M('shop')->where(array('shop_id'=>$shop_id))->data(array('shop_img'=>$img_url))->save();
        if(!$r){
          $this->ajaxReturn(array('code'=>'1','msg'=>'插入数据库失败'));
        }
      }else {
        $this->ajaxReturn(array('code'=>'1','msg'=>'保存图片失败'));
      }
      $this->ajaxReturn(array('code'=>'0','msg'=>'修改图片成功'));
    }
