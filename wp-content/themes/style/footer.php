<?php global $img_dir  ?>
			<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
                <div id="inner-footer" class="container footer__inner">
                    <div class="row">
                        <div class="footer__scroll-top">
                            <?php include($img_dir . 'common/scroll-top.svg'); ?>
                        </div>
                        <div class="col-sm-3">
                            <div class="footer__icon"><?php include($img_dir . 'common/phone.svg'); ?></div>
                            <div class="footer__text">
                                Розничный отдел:<br/>
                                (812) 337-14-27<br/>
                                (812) 740-18-72<br/>
                                &nbsp;<br/>
                                Оптовый отдел:<br/>
                                (812) 370-81-43<br/>
                                (812) 370-82-21<br/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="footer__icon"><?php include($img_dir . 'common/pin.svg'); ?></div>
                            <div class="footer__text">
                                г. Санкт-Петербург,<br/>
                                ул. Новолитовская, д. 15В<br/>
                                МЦ "Аквилон", 1 этаж, <br/>
                                секция 5<br/>
                                <br/>
                                Т: (812) 740-18-72<br/>
                                e-mail: heys@yandex.ru<br/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="footer__icon"><?php include($img_dir . 'common/pin.svg'); ?></div>
                            <div class="footer__text">
                                г. Санкт-Петербург,<br/>
                                ул. Варшавская, д.3<br/>
                                МЦ "Мебельный континент",<br/>
                                1 корпус, з этаж, секция 332 А<br/>
                                <br/>
                                Т: (812) 337-14-27<br/>
                                e-mail: heys@yandex.ru<br/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="footer__icon"><?php include($img_dir . 'common/pin.svg'); ?></div>
                            <div class="footer__text">
                                Склад (Производство)<br/>
                                п. Металлострой,<br/>
                                ул. Богайчука, д.1
                                <br/>
                                <br/>
                                Т: (812) 370 81 43<br/>
                                Т: (812) 370 82 21<br/>
                                e-mail: heys@yandex.ru<br/>

                            </div>
                        </div>

                    </div>

				</div>

			</footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<?php wp_footer(); ?>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
        <script type="text/javascript">
            $(function($){
                var addToAll = false;
                var gallery = false;
                var titlePosition = 'inside';
                $(addToAll ? 'img' : 'img.fancybox').each(function(){
                    var $this = $(this);
                    var title = $this.attr('title');
                    var src = $this.attr('data-big') || $this.attr('src');
                    var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
                    $this.wrap(a);
                });
                if (gallery)
                    $('a.fancybox').attr('rel', 'fancyboxgallery');
                $('a.fancybox').fancybox({
                    titlePosition: titlePosition
                });
            });
            $.noConflict();
        </script>
	</body>
</html>
