                </section>
            </div>
        </div>
        <footer id="footer">
            <?php if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p id="breadcrumbs" itemprop="breadcrumb">','</p>');
            } ?>
            <p id="copyright"><?php echo sprintf(__('Copyright &copy; %d Tristan Hall. All Rights Reserved.', 'th'), date('Y')); ?></p>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>