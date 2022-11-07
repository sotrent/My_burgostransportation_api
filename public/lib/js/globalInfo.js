$(".ui.dropdown").dropdown();
$('.ui.search').search({
  apiSettings: {
    url: 'getDataInfo.php?m=gpl&cad={query}',
  },
  fields: {
    results : 'items',
    //image : algo,
    title   : 'name'
  },
  minCharacters : 3
});
