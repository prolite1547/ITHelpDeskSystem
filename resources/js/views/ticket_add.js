export const generateExpirationInputMarkup = (category) => {

    let date;
    switch (category) {
        case 'hardware':
            date = moment().add(3,'days').format('YYYY-MM-DD HH:mm:ss');
            break;
        case 'software':
            date = moment().add(7,'days').format('YYYY-MM-DD HH:mm:ss');
            break;
        default:
            date = moment().format();
    }

    return `<input name="expiration" value="${date}" hidden>`;
};
