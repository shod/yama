<?php
/* @var $this AdvertsController */
/* @var $data Adverts */
$avatar_size['x'] = 30;
$avatar_size['y'] = 30;

?>

<div class="pin" data-id="278519558177115222" data-closeup-url="http://media-cache-ec4.pinterest.com/upload/278519558177115222_TiNCAw4J_c.jpg" 
data-width="500" data-height="331" style="top: 421px; left: 237px;" data-col="1">
    <div class="PinHolder">
		<!--div class="actions">
			<a class="Button Button11 WhiteButton ContrastButton repin_link" data-componenttype="MODAL_REPIN" data-id="278519558177115222" href="/pin/278519558177115222/repin/">
			<em></em><span>Repin</span>
			</a>
			<a class="Button WhiteButton ContrastButton Button11 likebutton" data-id="278519558177115222" data-text-like="Like" data-text-unlike="Unlike" href="#">
    <em></em>Like
  </a>

        
        
  <a class="Button Button11 WhiteButton ContrastButton comment" data-id="278519558177115222" href="#">
    <em></em>Comment
  </a>

      </div-->
      <a href="/pin/278519558177115222/" class="PinImage ImgLink">
          <img src="http://media-cache-ec6.pinterest.com/upload/278519558177115222_TiNCAw4J_b.jpg" alt="." data-componenttype="MODAL_PIN" class="PinImageImg" style="height: 127px;">
      </a>
    </div>
    <p class="description"><?= $data->text; ?></p>
    <!--p class="stats colorless">
      <span class="LikesCount">
          14 likes
      </span>
      <span class="CommentsCount hidden">
      </span>
        <span class="RepinsCount">
          20 repins
        </span>
    </p-->
    <!--div class="convo attribution clearfix">
        <a href="<?= Yii::app()->params->socialBaseUrl . 'user_id' ?>" title="Laila La La" class="ImgLink">
          <img src="http://media-cache-ec4.pinterest.com/avatars/Gaizin-1345771394.jpg" alt="Profile picture of Laila La La">
        </a>
        <p class="NoImage">
                <a href="<?= Yii::app()->params->socialBaseUrl . 'user_id' ?>">username</a> о <a href="/Gaizin/cars-motorcycles/"><?= $data->title; ?></a>
        </p>
    </div-->
  </div>