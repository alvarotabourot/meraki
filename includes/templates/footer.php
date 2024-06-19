</div> <!-- content -->
        <footer class="footer" id="contacto">
            <div class="contenido-footer">
                <p>Ante cualquier problema póngase en contacto con nosotros</p>

                <div class="formularioFooter">
                    <form action="<?= $_ENV['BASE_URL']?>enviarEmailAdmi" method="POST">
                        <input type="email" placeholder="Pon tu correo electronico" name="data[email]">
                        <input type="submit" value="Enviar">
                    </form>
                </div>
                <p>TODOS LOS DERECHOS RESERVADOS A &copy; MERAKI</p>
            </div>
        </footer>
        </div> <!-- .container-->
    </body>
</html>