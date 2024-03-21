## **Projektmunka**
A levelező tagozaton a  hallgatók 1-3 fős csapatokban kidolgoznak egy-egy teljes adatbázis alkalmazást az SSADM tervezéstől a számítógépes implementációig. Az alkalmazást a hallgatók személyesen mutatják be a gyakorlatvezetőnek a 13. és 14. szorgalmi héten, aki annak eredetiségét is ellenőrzi szakmai részletekre való rákérdezéssel. 

***Platform:* Oracle Database.** Ettől eltérni csak a gyakorlatvezető előzetes engedélyével lehet (pl. levelező hallgató MS SQL Server projekten dolgozik stb.). Access és MySQL nem választható. 

**A projektmunka pontszámának meghatározása:**

A projektmunkát két, jól elkülöníthető részre bontjuk a pontszámok meghatározásánál. Ezek rendre a Dokumentáció, Adatbázis + Alkalmazás megnevezéseket kapták. **Fontos**, hogy az adott részekre adható pontok százalékos arányát a projektmunkára összesen adható ponthoz képest az alábbi táblázat foglalja össze:



|**Projekt rész:**|**Adható pont:**|
| - | - |
|Dokumentáció|~30%|
|Adatbázis + Alkalmazás|~70%|

***Dokumentáció***

A projektmunkához egy számítógéppel készített tervezési dokumentáció készül. 

***Minimális elvárások a dokumentációval kapcsolatban:***

- A dokumentáció számítógéppel készített, szerkesztett dokumentum.
- A csapaton belül a munka felosztásának részletes leírása.
- Szöveges, részletes feladatleírás, követelménykatalógus (mi a megvalósítandó cél, milyen funkciókkal kell rendelkeznie a programnak)
- Adatfolyam-diagramok (logikai és fizikai adatfolyam-diagram legalább 1. és 2. szinten)
- Egyedmodell és E-K diagram
- Adatmodellezés és relációs adatelemzés (E-K diagram, E-K diagram leképezése, normalizálás, adattáblák leírása)
- Funkciómeghatározás **vagy** egyed-esemény mátrix **vagy** szerep-funkció mátrix

**Amennyiben a fent leírt minimális elvárások bármelyike nem teljesül a projekt kapcsán, úgy a projekt sikertelen (minden csapattag nulla pontot kap).** **Fontos**, hogy a minimális elvárások teljesítése nem azt jelenti, hogy a dokumentációra adható pontok mindegyikét megszerzi a hallgató. Az  elkészített  dokumentáció  igényessége,  részletessége  és  helyessége  is  szerepet  játszik  a pontozásnál. Valamint, a minimális elvárásokon felül a dokumentációban feltüntethető további elemekről (például menütervek, képernyőtervek stb.) az előadásanyagok, illetve a gyakorlati anyagok nyújtanak bővebb tájékoztatást.

***Adatbázis***

A projektmunka legfontosabb része.

***Minimális elvárások az adatbázissal kapcsolatban:***

- Összefüggő adattáblák száma legalább 7 darab.
- Adatrekordok száma az adatbázis egészében logikusan elosztva legalább 150 darab.
- A feltöltött adatrekordokon be lehessen mutatni a rendszer működését.
- Összetett lekérdezések száma, amelyek legalább két tábla összekapcsolását, ezen kívül csoportosítást összesítő függvénnyel, és/vagy alkérdést tartalmaznak: legalább 8 darab.
- Integritás-ellenőrzés (kulcs és külső kulcs kapcsolatok, ON UPDATE és ON DELETE megszorítások).
- A nem számláló funkciót megvalósító triggerek száma legalább 2 darab.
- Az alkalmazásban használt, adatbázisban tárolt eljárások és függvények száma legalább 2 darab.

**Amennyiben a fent leírt minimális elvárások bármelyike nem teljesül a projekt kapcsán, úgy a projekt sikertelen (minden csapattag nulla pontot kap).** **Fontos**, hogy a minimális elvárások teljesítéséből nem következik, hogy az Adatbázisra adható pontok mindegyikét megkapja a hallgató. A kódolás minősége, átláthatósága és a helyes működés is pontozásra kerül. A további pontokat a minimális elvárásokban feltüntetett elemekben szereplő darabszámok meghaladásával lehet megszerezni, továbbá az Adatbázishoz szorosan kapcsolódó funkciók megvalósításával, például  érzékeny  adatok  (jelszavak)  hash-elt  tárolása,  SQL-befecskendezés  (SQL-injection) kivédése, nézettáblák alkalmazása, stb.

***Alkalmazás***

Kényelmes használatot biztosít a felhasználók számára.

***Minimális elvárások az alkalmazással kapcsolatban:***

- Az alkalmazásnak rendelkeznie kell adatfelvitelt, -módosítást, -törlést és adatok lekérdezését szolgáló grafikus vagy webes felhasználói felülettel.
- Az alkalmazás funkcionalitását tekintve megfelel a Dokumentációban leírtaknak.

**Amennyiben a fent leírt minimális elvárások bármelyike nem teljesül a projekt kapcsán, úgy a projekt sikertelen (minden csapattag nulla pontot kap).** **Fontos**, hogy a minimális elvárások teljesítéséből nem következik, hogy az alkalmazásra adható pontok mindegyikét megkapja a hallgató. Az értékelési szempontokban szerepet kap az alkalmazás használhatósága/letisztultsága.

**Oktatói javaslat:** a feladatok felosztását a csapat maga határozza meg, de ügyelni kell rá, hogy minden csapattagnak arányos munkája legyen. Minden feladathoz előre ki kell jelölni a felelősöket. A frontend és backend részt egy-egy funkció kapcsán nem érdemes szétválasztani, mert pontszám a funkció  megvalósítására  jár,  vagyis  akár  a  grafikus  felhasználói  felület,  akár  a  funkció háttérműveletét megvalósító rész hiányzik, a funkció nem látja el a feladatát, ezáltal nem értékelhető.
