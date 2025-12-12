<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solcarlus - Convertisseur XLS → XLSX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cinzel', 'Times New Roman', serif;
            background: linear-gradient(rgba(20, 10, 0, 0.85), rgba(40, 20, 10, 0.9)),
                        url('solcarlus_fond.png') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5),
                        inset 0 0 0 2px rgba(212, 175, 55, 0.3);
            border: 3px solid #d4af37;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            border-bottom: 3px solid #c19a6b;
            padding-bottom: 25px;
        }

        .header h1 {
            color: #8b0000;
            font-size: 2.8rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .header .subtitle {
            color: #654321;
            font-size: 1.1rem;
            font-style: italic;
            letter-spacing: 1px;
        }

        .upload-zone {
            border: 3px dashed #c19a6b;
            border-radius: 10px;
            padding: 50px 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), rgba(193, 154, 107, 0.05));
            margin-bottom: 25px;
        }

        .upload-zone:hover {
            border-color: #d4af37;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(193, 154, 107, 0.1));
            transform: translateY(-2px);
        }

        .upload-zone.dragover {
            border-color: #ffd700;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.15), rgba(212, 175, 55, 0.15));
        }

        .upload-icon {
            font-size: 4rem;
            color: #c19a6b;
            margin-bottom: 15px;
        }

        .upload-text {
            color: #654321;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .upload-hint {
            color: #8b6f47;
            font-size: 0.9rem;
        }

        input[type="file"] {
            display: none;
        }

        .file-list {
            margin: 25px 0;
        }

        .file-item {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(193, 154, 107, 0.05));
            border: 2px solid #c19a6b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .file-item:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(193, 154, 107, 0.1));
            transform: translateX(5px);
        }

        .file-name {
            color: #654321;
            font-weight: 600;
        }

        .file-status {
            font-size: 0.9rem;
            color: #8b6f47;
        }

        .btn {
            background: linear-gradient(135deg, #8b0000, #a52a2a);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.4);
            border: 2px solid #d4af37;
        }

        .btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #a52a2a, #8b0000);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.6);
        }

        .btn:disabled {
            background: linear-gradient(135deg, #999, #777);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .success-msg {
            background: linear-gradient(135deg, rgba(34, 139, 34, 0.1), rgba(50, 205, 50, 0.05));
            border: 2px solid #228b22;
            color: #006400;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            font-weight: 600;
        }

        .error-msg {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(178, 34, 34, 0.05));
            border: 2px solid #dc143c;
            color: #8b0000;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            font-weight: 600;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #c19a6b;
            color: #654321;
            font-style: italic;
            font-size: 0.9rem;
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            border: 4px solid rgba(212, 175, 55, 0.3);
            border-top: 4px solid #d4af37;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .upload-zone {
                padding: 35px 20px;
            }

            .upload-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SOLCARLUS</h1>
            <div class="subtitle">⚔️ Convertisseur XLS → XLSX ⚔️</div>
        </div>

        <form id="uploadForm" enctype="multipart/form-data">
            <div class="upload-zone" id="uploadZone">
                <div class="upload-icon">🏛️</div>
                <div class="upload-text">Déposez vos fichiers XLS ici</div>
                <div class="upload-hint">ou cliquez pour sélectionner</div>
                <input type="file" id="fileInput" name="files[]" multiple accept=".xls">
            </div>

            <div class="file-list" id="fileList"></div>

            <button type="submit" class="btn" id="convertBtn" disabled>⚔️ CONVERTIR EN XLSX ⚔️</button>
        </form>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <div style="color: #654321; font-weight: 600;">Conversion en cours...</div>
        </div>

        <div id="message"></div>

        <div class="footer">
            "Veni, Vidi, Converti" - Je suis venu, j'ai vu, j'ai converti
        </div>
    </div>

    <script>
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        const convertBtn = document.getElementById('convertBtn');
        const message = document.getElementById('message');
        const uploadForm = document.getElementById('uploadForm');
        const loading = document.getElementById('loading');

        uploadZone.addEventListener('click', () => fileInput.click());

        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            fileInput.files = e.dataTransfer.files;
            handleFiles();
        });

        fileInput.addEventListener('change', handleFiles);

        function handleFiles() {
            const files = Array.from(fileInput.files);
            const xlsFiles = files.filter(f => f.name.toLowerCase().endsWith('.xls'));
            
            if (xlsFiles.length === 0) {
                showMessage('Veuillez sélectionner des fichiers .xls', 'error');
                convertBtn.disabled = true;
                return;
            }

            displayFiles(xlsFiles);
            convertBtn.disabled = false;
            message.innerHTML = '';
        }

        function displayFiles(files) {
            fileList.innerHTML = files.map(file => `
                <div class="file-item">
                    <span class="file-name">📜 ${file.name}</span>
                    <span class="file-status">${(file.size / 1024).toFixed(2)} KB</span>
                </div>
            `).join('');
        }

        function showMessage(text, type) {
            message.innerHTML = `<div class="${type}-msg">${text}</div>`;
        }

        uploadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(uploadForm);
            
            convertBtn.disabled = true;
            loading.classList.add('active');
            message.innerHTML = '';

            try {
                const response = await fetch('convert.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showMessage(`✅ ${result.converted} fichier(s) converti(s) avec succès!`, 'success');
                    
                    // Télécharger les fichiers convertis
                    result.files.forEach(file => {
                        const a = document.createElement('a');
                        a.href = file.path;
                        a.download = file.name;
                        a.click();
                    });

                    // Réinitialiser le formulaire
                    uploadForm.reset();
                    fileList.innerHTML = '';
                    convertBtn.disabled = true;
                } else {
                    showMessage('❌ Erreur: ' + result.message, 'error');
                }
            } catch (error) {
                showMessage('❌ Erreur de connexion: ' + error.message, 'error');
            } finally {
                loading.classList.remove('active');
                convertBtn.disabled = fileInput.files.length === 0;
            }
        });
    </script>
</body>
</html>