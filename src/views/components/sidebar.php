<script type="text/x-template" id="template-sidebar">
    <div class="sidebar">
        <div class="sidebar-menu">
            <div class="sidebar-menu-item" v-if="is_dev" @click="set_menu({title: 'Languages'})">Languages</div>
            <div class="sidebar-menu-item" :class="{'active': item.active}" v-if="is_dev || !item.is_dev" v-for="item in menu" v-text="item.title" @click="set_menu(item)"></div>
        </div>
    </div>
</script>
    
<script src="/vendor/fastadminpanel/js/components/sidebar.js"></script>