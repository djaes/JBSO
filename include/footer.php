    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!empty($custom_js)): ?>
        <?php foreach ($custom_js as $js): ?>
            <script src="<?= JS_URL . '/' . $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
