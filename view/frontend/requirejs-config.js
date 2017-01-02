var config = {
    map: {
        '*': {
            'layoutChart': 'Farior_LayoutStructure/js/chart'
        }
    },
    paths: {
        'Treant': 'Farior_LayoutStructure/js/vendor/Treant',
        'raphael': 'Farior_LayoutStructure/js/vendor/raphael',
        'dragscroll': 'Farior_LayoutStructure/js/vendor/dragscroll'
    },
    shim: {
        'Treant': {
            'deps': ['jquery', 'raphael'],
            'exports': 'Treant'
        }
    }
};
