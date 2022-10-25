  <?php foreach ($result as $memo) { ?>
    <div id="cards">
      <div class="card">
        <?php if ($memo['picture']) : ?>
          <div class="picture"><a href="detail.php?id=<?php echo $memo['id']; ?>"><img src="picture/<?php echo $memo['picture']; ?>"></a>
          <?php else : ?>
            <div class="picture"><a href="detail.php?id=<?php echo $memo['id']; ?>"><img src="empty_image/20200501_noimage.jpg"></a>
            </div>
          <?php endif; ?>
          <div class="description">
            <p>[部位]<?php echo $memo['part']; ?></p>
            <br>
            <p class="day">[投稿日]<?php echo $memo['created']; ?></p>
          </div>
          </div>
      </div>
    </div>
  <?php } ?>
  <div class="btn-area">
    <div class="pagination">
      <?php if ($page > 1) : ?>
        <a href="index.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a> |
      <?php endif ?>
      <?php if ($page < $max_page) : ?>
        <a href="index.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
      <?php endif ?>
    </div>
