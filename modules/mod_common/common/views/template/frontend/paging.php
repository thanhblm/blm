<?php
if (isset ($paging)) {
    $data = $paging->records;
    if (!empty ($data) && count($data) > 0) {
        ?>

        <nav class="navigation pagination">
            <div class="nav-links">
                <a class="prev page-numbers" href="javascript:<?= $changePageJs ?>(<?= $paging->currentPage - 1 ?>)"> <i
                            class="fa fa-long-arrow-left"></i> </a>

                <?php
                for ($i = $paging->firstPage; $i <= $paging->lastPage; $i++) {
                    if ($i == $paging->currentPage) {
                        ?>
                        <span class="page-numbers current">
											<span class="meta-nav screen-reader-text"> </span><?= $i ?>
										</span>
                        <?php
                    } else {
                        ?>
                        <a class="page-numbers" href="javascript:<?= $changePageJs ?>(<?= $i ?>)"><span
                                    class="meta-nav screen-reader-text"> </span><?= $i ?></a>
                        <?php
                    }
                }
                ?>
                <a class="next page-numbers" href="javascript:<?= $changePageJs ?>(<?= $paging->currentPage + 1 ?>)"> <i
                            class="fa fa-long-arrow-right"></i> </a>
            </div>
        </nav>
        <?php
    }
}
?>