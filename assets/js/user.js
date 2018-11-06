document.getElementById('analyze-button').addEventListener('click', () => {
    const button = document.getElementById('analyze-button');

    button.disabled = true;
    button.textContent = 'Analyzing...';

    $.ajax({
        url: '/twitterai/chirp.php',
        type: 'post',
        data: {
            query: document.getElementById('searchUserOneInput').value
        },
        dataType: 'json',
        success: (response) => {
            console.log(response);

            document.getElementById('result-body').innerHTML = `
                <div class="card bg-primary text-white mb-5">
                    <div class="card-body">
                        <h4 class="card-title text-center">
                            Results
                        </h4>
                        <h1>😂</h1>
                    </div>
                </div>
            `;
        },
        error: () => {
            console.log('error!');
        },
        complete: () => {
            button.textContent = 'Analyze';
            button.disabled = false;
        }
    });
});
