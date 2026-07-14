<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure JS Scanner Test</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            max-width: 500px;
            margin: auto;
        }

        #reader {
            width: 100%;
            min-height: 250px;
            border: 2px dashed #ccc;
            margin-top: 20px;
            background: #f3f4f6;
        }

        #result-box {
            margin-top: 20px;
            padding: 15px;
            border: 2px solid #10b981;
            background: #ecfdf5;
            display: none;
            border-radius: 8px;
        }

        button {
            padding: 12px 20px;
            font-size: 16px;
            margin: 5px 0;
            cursor: pointer;
            background: #101828;
            color: white;
            border: none;
            border-radius: 6px;
            width: 100%;
        }

        button:disabled {
            background: #99a1af;
            cursor: not-allowed;
        }

        .error-log {
            color: #dc2626;
            margin-top: 15px;
            font-size: 14px;
            background: #fef2f2;
            padding: 10px;
            border-radius: 6px;
            display: none;
        }
    </style>
</head>

<body>

    <h2>Barcode Scanner Test</h2>
    <p>Testing Minhaz's html5-qrcode library in pure JS.</p>

    <button id="start-btn">Start Camera</button>
    <button id="stop-btn" disabled>Stop Camera</button>

    <div id="error-log" class="error-log"></div>

    <div id="reader"></div>

    <div id="result-box">
        <strong>Scanned Barcode:</strong> <br>
        <span id="scanned-data" style="font-size: 24px; font-weight: bold; color: #101828;"></span>
    </div>

    <script>
        let scanner = null;
        const startBtn = document.getElementById('start-btn');
        const stopBtn = document.getElementById('stop-btn');
        const resultBox = document.getElementById('result-box');
        const scannedData = document.getElementById('scanned-data');
        const errorLog = document.getElementById('error-log');

        startBtn.addEventListener('click', () => {
            // Reset UI
            errorLog.style.display = 'none';
            resultBox.style.display = 'none';

            // 2. Initialize the scanner
            scanner = new Html5Qrcode("reader");

            // 3. Start the camera
            scanner.start({
                    facingMode: "environment"
                }, // Forces the back camera
                {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 150
                    } // Standard 1D barcode shape
                },
                (decodedText, decodedResult) => {
                    // SUCCESS CALLBACK: A barcode was found
                    scannedData.innerText = decodedText;
                    resultBox.style.display = 'block';

                    // Optional: You can make it stop immediately after finding 1 item
                    // stopScanner(); 
                },
                (errorMessage) => {
                    // ERROR CALLBACK: Ignored. This fires constantly while it looks for a code.
                }
            ).then(() => {
                // If the camera starts successfully, update the buttons
                startBtn.disabled = true;
                stopBtn.disabled = false;
            }).catch((err) => {
                // HARD ERROR: Browser blocked it, or no HTTPS
                errorLog.innerHTML = "<strong>Camera Blocked:</strong> " + err +
                    "<br><br>Make sure you are testing on an HTTPS connection!";
                errorLog.style.display = 'block';
            });
        });

        stopBtn.addEventListener('click', stopScanner);

        function stopScanner() {
            if (scanner) {
                scanner.stop().then(() => {
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                    scanner.clear();
                }).catch((err) => {
                    console.error("Failed to stop scanner.", err);
                });
            }
        }
    </script>
</body>

</html>
