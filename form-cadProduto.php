<body>
    <?php include 'header.php'; ?>
<div class="container">
    <h2>Cadastro de Produto</h2>
    <form action="cria-produto.php" method="POST">

        <div class="field">
            <label>Nome *</label>
            <input type="text" name="name" required>
        </div>

        <div class="field">
            <label>Descrição *</label>
            <textarea name="description" rows="4" required></textarea>
        </div>

        <div class="field">
            <label>Preço *</label>
            <input type="text" name="price" required>
        </div>

        <div class="field">
            <label>Preço Promocional *</label>
            <input type="text" name="promotional_price" required>
        </div>

        <div class="field">
            <label>Custo *</label>
            <input type="text" name="cost" required>
        </div>

        <div class="field">
            <label>Peso *</label>
            <input type="text" name="weight" required>
        </div>

        <div class="field">
            <label>Largura (cm) *</label>
            <input type="text" name="width" required>
        </div>

        <div class="field">
            <label>Altura (cm) *</label>
            <input type="text" name="height" required>
        </div>

        <div class="field">
            <label>Comprimento (cm) *</label>
            <input type="text" name="length" required>
        </div>

        <div class="field">
            <label>Marca *</label>
            <input type="text" name="brand" required>
        </div>

        <button type="submit">Salvar Produto</button>
    </form>
</div>
    <?php include 'footer.php'; ?>
</body>
</html>
