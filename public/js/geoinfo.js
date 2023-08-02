var geoInfo = {
    city: 'UNKNOWN',
    continent: 'UNKNOWN',
    continentCode: 'UNKNOWN',
    countryCapital: 'UNKNOWN',
    countryCode: 'UNKNOWN',
    countryPhone: 'UNKNOWN',
    currency: 'UNKNOWN',
    currencyCode: 'UNKNOWN',
};

let userIP = null;

const getIP = async () => {
    return await fetch('https://api.ipify.org?format=json')
        .then(response => response.json());
}

const getInfo = async (ip) => {
    /* https://ipstack.com/, https://ipwhois.io/, https://ipapi.co/ */
    return await fetch('https://ipwhois.app/json/' + ip + '?lang=es')
        .then(response => response.json());
}

getIP().then(response => {
    userIP = response.ip;
    getInfo(userIP).then(location => {
        if (location) {
            geoInfo = {
                city: location['city'],
                continent: location['continent'],
                continentCode: location['continenet_code'],
                countryCapital: location['country_capital'],
                countryCode: location['country_code'],
                countryPhone: location['country_Phone'],
                currency: location['currency'],
                currencyCode: location['currency_code'],
            }
        }
    })
});

