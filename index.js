var axios = require('axios');
var fs = require('fs');
const { title } = require('process');
var totalPage = 30;
var all = [];
var page = 1;



const getCarsbyPage = () => {
    new Promise((resolve, reject) => {
        var config = {
            method: 'get',
            url: 'https://api.cars.co.za/fw/public/v3/vehicle?page%5Boffset%5D=' + 20 * page + '&page%5Blimit%5D=20&sort%5Bdate%5D=desc',
            headers: {}
        };

        axios(config)
            .then(function (response) {
                totalPage = response.data.meta.totalPages;
                fs.writeFile("./scrapingBycarsCo/data" + page + ".json", JSON.stringify(response.data.data), function (err, result) {
                    if (err) console.log('error', err);
                });
                console.log(`page${page}`)
                page++;
                if (page < totalPage) {
                    getCarsbyPage(page);
                }
                else {
                    console.log("end");
                    fs.readdir("./scrapingBycarsCo", (err, files) => {
                        for (let i = 1; i <= files.length - 1; i++) {
                            var data = require("./scrapingBycarsCo/data" + i + ".json");
                            all.push(data);
                            if (i == files.length - 1) {
                                console.log("scraping file created")
                                fs.writeFile("data1.json", JSON.stringify(all), function (err, result) {
                                    if (err) console.log('error', err);
                                });
                                console.log("scarping finished")
                                setTimeout(() => {
                                    merge()
                                }, 2000);
                            }
                        }
                    });
                }
            })
            .catch(function (error) {
                reject(error)
            });
    });
}



const checkFinial = () => {
    var config = {
        method: 'get',
        url: 'https://api.cars.co.za/fw/public/v3/vehicle?page%5Boffset%5D=' + 20 * page + '&page%5Blimit%5D=20&sort%5Bdate%5D=desc',
        headers: {}
    };

    axios(config)
        .then(function (response) {
            fs.readdir("./scrapingBycarsCo", (err, files) => {
                if (files.length <= response.data.meta.totalPages) {
                    console.log("scraping don't finised");
                    page = files.length;
                    getCarsbyPage();
                }
                else {
                    for (let i = 1; i <= files.length - 1; i++) {
                        var data = require("./scrapingBycarsCo/data" + i + ".json");
                        all.push(data);
                        if (i == files.length - 1) {
                            console.log("scraping file created")
                            fs.writeFile("data1.json", JSON.stringify(all), function (err, result) {
                                if (err) console.log('error', err);
                            });
                            console.log("scarping finished")
                            setTimeout(() => {
                                merge()
                            }, 2000);
                        }
                    }
                }
            });
        })
}


checkFinial();
// getCarsbyPage();


const merge = () => {
    const data1 = require("./data1.json");
    const data2 = require("./data2.json");
    const fs = require('fs');

    var allCars1 = [];
    var allCars2 = [];
    var count = 0;

    const getOne = new Promise(function (resolve, reject) {
        for (const i in data1) {
            for (const j in data1[i]) {
                let imageTitle = data1[i][j].attributes['title'].replace(/[^a-zA-Z0-9 ]/g, '');
                imageTitle = imageTitle.replace(' ', '-');
                let imageUrl = "https://img-ik.cars.co.za/ik-seo/carsimages/" + data1[i][j].id + "/" + imageTitle + data1[i][j].attributes['image']['extension'];

                var inputData = {
                    category: 1,
                    id: data1[i][j].id,
                    imgURL: imageUrl,
                    mileage: data1[i][j].attributes.mileage ? data1[i][j].attributes.mileage : "None",
                    transmission: data1[i][j].attributes.transmission ? data1[i][j].attributes.transmission : "None",
                    province: data1[i][j].attributes.province ? data1[i][j].attributes.province : "None",
                    fuel_type: data1[i][j].attributes.fuel_type ? data1[i][j].attributes.fuel_type : "None",
                    colour: data1[i][j].attributes.colour ? data1[i][j].attributes.colour : "None",
                    price: data1[i][j].attributes.price ? data1[i][j].attributes.price : 0,
                    new_or_used: data1[i][j].attributes.new_or_used ? data1[i][j].attributes.new_or_used : "None",
                    title: data1[i][j].attributes.title ? data1[i][j].attributes.title : "None",
                    location: data1[i][j].attributes.province ? data1[i][j].attributes.province : "None",
                    model: data1[i][j].attributes.model ? data1[i][j].attributes.model : "None",
                    siteURL: data1[i][j].attributes.website_url,
                    makeYear: data1[i][j].attributes.year ? data1[i][j].attributes.year : 0
                }
                allCars1.push(inputData);
                count++;
            }
        }
        resolve(allCars1);
    });

    const getTwo = new Promise(function (resolve, reject) {
        for (const i in data2) {
            var k = 0;
            var mileage = 0, new_or_used = "", transmission = "Manual";

            if (data2[i].summaryIcons && (data2[i].summaryIcons).length > 0) {
                data2[i].summaryIcons.forEach(element => {
                    if (k == 0) {
                        new_or_used = element.text
                        if (new_or_used == "New Car") {
                            new_or_used = "New";
                        }
                        if (new_or_used == "Used Car") {
                            new_or_used = "Used";
                        }
                    }
                    if (k == 1) {
                        element.text == "Automatic" || element.text == "Manual" ? mileage = 0 : mileage = element.text
                    }
                    if (k == 2) { transmission = element.text }
                    k++;
                });
            }


            var price = data2[i].price;
            if (price) {
                price = price.substring(2);
            }
            else {
                price = 0
            }

            var inputTitle = data2[i].registrationYear + " ";
            inputTitle = inputTitle + (data2[i].makeModelLongVariant ? data2[i].makeModelLongVariant : "None");
            var inputData = {
                category: 2,
                id: data2[i].listingId,
                imgURL: data2[i].imageUrl ? data2[i].imageUrl : "None",
                mileage: mileage ? mileage : "None",
                transmission: transmission ? transmission : "None",
                province: data2[i].dealerCityName ? data2[i].dealerCityName : "None",
                fuel_type: 'None',
                colour: 'None',
                price: parseInt(price),
                new_or_used: new_or_used ? new_or_used : "None",
                title: inputTitle,
                location: data2[i].dealerCityName ? data2[i].dealerCityName : "None",
                model: data2[i].make ? data2[i].make : "None",
                siteURL: 'https://www.autotrader.co.za' + data2[i]['listingUrl'],
                makeYear: data2[i].registrationYear ? data2[i].registrationYear : 0,
                dealername: data2[i].dealerName,
                dealerImg: data2[i].dealerLogoImageUrl ? data2[i].dealerLogoImageUrl : "None"
            }
            allCars2.push(inputData);
            count++;
        }
        resolve(allCars2);
    });

    Promise.all([getOne, getTwo]).then((values) => {
        var all = values[0].concat(values[1]);
        fs.writeFile("ALLCAR.json", JSON.stringify(all), function (err, result) {
            if (err) console.log('error', err);
        });
        console.log("merge finished")
    });
}