<?php
use App\Services\Page;
?>

<!doctype html>
<html lang="en">
<?php
Page::part('head');
?>
<body>
<?php
Page::part('navbar');
?>

    <div class="container">
    </div>


</body>
<script>

    (() => {
        fetch('/api/redis').then((response) => {
            return response.json();
        }).then((data) => {
            articles(data.data);
        })
    })()

    const container = document.querySelector('.container');
    const articles = (data) => {
       Object.entries(data).forEach(entry => {
           const [key, value] = entry;
           const link = document.createElement('a');
           link.textContent = 'delete';
           link.className = 'remove';
           link.id = key;
           const li = document.createElement('li');
           li.textContent = key + ':' + value;
           li.id = key;
           li.appendChild(link);
           container.append(li);

       });
   }

    document.addEventListener('click',function(e){
        const key = e.target.id;
        deleteHandler(key);
    });

    const deleteHandler = (key) => {
        if(key){
            if (confirm('Do you really want to delete?')){
                fetch('/api/delete/' + key, {
                    method: 'DELETE'
                }).then((response) => {
                    if (response.status === 200){
                        document.getElementById(key).remove();
                    }
                })
            }
        }
    }
</script>
</html>