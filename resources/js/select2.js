export const branchSelect2 = {
    ajax: {
        url: '/select/store',
        processResults: function (data) {
            return {
                results: data.data
            };
        }
    }
};

export const psitionSelect2 = {
    width: '100%',
    ajax: {
        url: '/select/position',
        processResults: function (data) {
            return {
                results: data.data
            };
        }
    }
};

export const deptSelect2 = {
    width: 'auto',
    ajax: {
        url: '/select/department',
        processResults: function (data) {
            return {
                results: data.data
            };
        }
    }
};

export const cntctSelect2 = {
    width: '30%',
    ajax: {
        url: '/select/contact',
        processResults: function (data) {
            data = $.map(data.data, (obj) => {
                return {
                    text: obj.store_name,
                    children: obj.contact_numbers.map(obj2 => {
                        return {
                            id: obj2.id,
                            text: obj2.number
                        }
                    })
                }
            });

            return {
                results: data
            };
        }
    }
};
