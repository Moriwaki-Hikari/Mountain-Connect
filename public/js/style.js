(() => {
  $('.delete').click(function(e) {
    const result = confirm('削除しますか？');
    if(result) {
    } else {
      e.preventDefault();
      alert("キャンセルしました。");
    }
  });

})();
