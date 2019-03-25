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

<field-modulelink>

    <div class="{ Object.keys(options).length > 10 ? 'uk-scrollable-box':'' }">

        <p class="uk-text-capitalize">{ App.i18n.get('Select') } {opts.module}:</p>

        <div class="uk-margin-small-top" each="{ option in options }">

            <a class="{ parent.id(option._id,parent.selected)!==-1 ? 'uk-text-primary':'uk-text-muted' }" onclick="{ parent.toggle }" title="{ option.label }">

                <i class="uk-icon-{ parent.id(option._id,parent.selected)!==-1 ? 'circle':'circle-o' } uk-margin-small-right"></i>

                <img class="uk-margin-small-right uk-svg-adjust" src="{ option.icon ? App['base_route'] + '/assets/app/media/icons/' + option.icon : App['base_route'] + '/modules/' + opts.module + '/icon.svg'}" width="18px" alt="icon" style="color:{ option.color }" data-uk-svg>

                { option[opts.display] || option.label || option.name }{ option.description ? ' | ' + option.description : '' }

            </a>

        </div>

    </div>

    <span class="uk-text-small uk-text-muted" if="{ Object.keys(options).length > 10}">{selected.length} { App.i18n.get('selected') }</span>

    <script>

        var $this = this;

        // console.log(opts);

        this.selected = [];
        this.options = [];

        this.on('mount', function() {

            $this.selected = this.root.$value || [];

            var options = {};

            if (opts.filter) {
                options.filter = opts.filter;
            }

            App.request('/modulelink/get', {module:opts.module,options:options}).then(function(data){
                $this.options = data;
                // console.log(data);
                $this.update();
            });

        });

        this.id = function(needle, haystack) {

            return haystack.map(function(e) { return e._id; }).indexOf(needle);

        }

        toggle(e) {

            var option = {
                    _id     : e.item.option._id,
                    name    : e.item.option.name,
                    module  : opts.module,
                    display : e.item.option[opts.display] || e.item.option.label || e.item.option.name
                },
                index = this.id(option._id, this.selected);

            if (index == -1) {
                this.selected.push(option);
            } else {
                this.selected.splice(index, 1);
            }

            this.$setValue(this.selected);
        }

    </script>

</field-modulelink>