App.Utils.renderer.modulelink = function(v) {
    var cnt = Array.isArray(v) ? v.length : 0;
    let tooltip = [];
    if (cnt) {
        v.forEach(function(link) {
            tooltip.push(link.display)
        });
    }
    return '<span class="uk-badge" title="'+tooltip.join(', ')+'" data-uk-tooltip>'+(cnt+(cnt == 1 ? ' Link' : ' Links'))+'</span>';
};