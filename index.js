const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.goto('https://www.mgm.gov.tr/tahmin/il-ve-ilceler.aspx?il=Elazig');
  
  let element  = await page.$("#pages > div > section > div.anlik-durum > div.anlik-sicaklik > div.anlik-sicaklik-deger.ng-binding");
  const derece = await page.evaluate(element => element.textContent, element);

  let nemelement  = await page.$("#pages > div > section > div.anlik-durum > div.anlik-diger > div.anlik-nem > div.anlik-nem-deger > div.anlik-nem-deger-kac.ng-binding");
  const nem = await page.evaluate(nemelement => nemelement.textContent, nemelement);
  console.log(derece.replace(',','.'),nem.replace(',','.'));
  await browser.close();
})();