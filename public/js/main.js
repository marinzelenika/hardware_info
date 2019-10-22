const items = document.getElementById('items');

if(items){
    items.addEventListener('click', (e) => {
        if(e.target.className === 'btn btn-danger delete-item'){
            if(confirm('Jeste li sigurni?')){
                const id = e.target.getAttribute('data-id')

                    fetch(`/item/delete/${id}`, {
                        method: 'DELETE'
                      }).then(res => window.location.reload());
                
            }
        }
    })
}