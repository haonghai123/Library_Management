                <?php
                if (is_admin_login()) {
                ?>
                    </main>
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid px-4">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; Open Library <?php echo date('Y'); ?></div>
                                <div>
                                    <a href="#">Chính sách bảo mật</a>
                                    &middot;
                                    <a href="#">Điều kiện &amp; Điều kiện</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    </div>
                    </div>
                <?php
                } else {
                ?>
                    <footer class="pt-3 mt-4 text-muted text-center border-top">
                        &copy; <?php echo date('Y'); ?>
                    </footer>
                    </div>
                    </main>
                <?php
                }
                ?>

                <script src="asset/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="asset/js/scripts.js"></script>
                <script src="asset/js/simple-datatables@latest.js" crossorigin="anonymous"></script>
                <script src="asset/js/datatables-simple-demo.js"></script>

                </body>

                </html>