<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Converter Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .input-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        textarea, input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .output {
            margin-top: 20px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 4px;
        }
        .copy-btn {
            display: block;
            margin: 20px 0;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }
        .copy-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Text to Custom Base64 Converter</h2>
    <form method="POST" action="">
        <div class="input-group">
            <label for="inputText">Input Text:</label>
            <textarea name="inputText" id="inputText" rows="5" placeholder="Enter text here..."><?php if (isset($_POST['inputText'])) echo htmlspecialchars($_POST['inputText']); ?></textarea>
        </div>
        <button type="submit">Convert</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['inputText'])) {
        $inputText = htmlspecialchars($_POST['inputText']); // Secure the input

        // Function to encode the text into the format, splitting it into 5-character chunks
        function encodeToCustomBase64($text) {
            // Split the input text into chunks of 5 characters
            $chunks = str_split($text, 5);
            $encodedResult = '';

            foreach ($chunks as $chunk) {
                // Generate two random numbers between 10 and 30
                $randomNumber1 = rand(10, 30);
                $randomNumber2 = rand(10, 30);
                
                // Encode each chunk in Base64 and add the format with the random numbers
                $encodedResult .= "=?[rndn_$randomNumber1][rndn_$randomNumber2]UTF-8?B?" . base64_encode($chunk) . "?= ";
            }
            return trim($encodedResult); // Trim trailing space
        }

        // Call the function and display the output
        $outputText = encodeToCustomBase64($inputText);

        echo "<div class='output' id='outputText'><strong>Output:</strong><br>" . nl2br($outputText) . "</div>";
        echo "<button class='copy-btn' onclick='copyToClipboard()'>Copy to Clipboard</button>";
    }
    ?>

</div>

<script>
    function copyToClipboard() {
        // Get the output text
        var outputText = document.getElementById('outputText').innerText;
        
        // Create a temporary textarea element to hold the text
        var tempTextarea = document.createElement('textarea');
        tempTextarea.value = outputText;
        document.body.appendChild(tempTextarea);

        // Select and copy the text
        tempTextarea.select();
        document.execCommand('copy');

        // Remove the temporary textarea element
        document.body.removeChild(tempTextarea);

        // Notify user that text was copied
        alert('Copied to clipboard!');
    }
</script>

</body>
</html>
