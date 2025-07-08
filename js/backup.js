function MessageBackup(Message = null,Color = 'red')
{
    if (Message === null)
    {
        SetElementValue('Message-BackUp', '');
    }
    else
    {
        SetElementValue('Message-BackUp', '<div class="ui '+Color+' message">'+Message+'</div>');
    }
}

function SelectAll(ID,Set)
{
    document.querySelectorAll(`#${ID} input`).forEach((Item)=>{
        Item.checked = Set;
    });
}

$('#fileInput').change(function () {
    $('#fileDisplay').val(this.files[0].name);
});