/*
 * EEPROM Clear
 *
 * Sets all of the bytes of the EEPROM to 0.
 * Please see eeprom_iteration for a more in depth
 * look at how to traverse the EEPROM.
 *
 * This example code is in the public domain.
 */

#include <EEPROM.h>


//*****  G R A B A R  EN LA  E E P R O M  *********
void graba(int addr, String a) {
 int tamano = (a.length() + 1);
 Serial.print(tamano);
 char inchar[30];    //'30' Tamaño maximo del string
 a.toCharArray(inchar, tamano);
 EEPROM.write(addr, tamano);
 for (int i = 0; i < tamano; i++) {
  addr++;
  EEPROM.write(addr, inchar[i]);
 }
 EEPROM.commit();
}


//*****  L E E R   EN LA  E E P R O M    ************
String lee(int addr) {
 String nuevoString;
 int valor;
 int tamano = EEPROM.read(addr);
 for (int i = 0;i < tamano; i++) {
  addr++;
  valor = EEPROM.read(addr);
  nuevoString += (char)valor;
 }
 return nuevoString;
}

void setup() {
  // initialize the LED pin as an output.
  Serial.begin(115200);
  EEPROM.begin(4096);
  Serial.println("comienzo");
  //pinMode(13, OUTPUT);
  
  /***
    Iterate through each byte of the EEPROM storage.

    Larger AVR processors have larger EEPROM sizes, E.g:
    - Arduno Duemilanove: 512b EEPROM storage.
    - Arduino Uno:        1kb EEPROM storage.
    - Arduino Mega:       4kb EEPROM storage.

    Rather than hard-coding the length, you should use the pre-provided length function.
    This will make your code portable to all AVR processors.
  ***/
graba(70, "0");
 graba(1, "0");
 graba(30, "0");

  for (int i = 0 ; i < EEPROM.length() ; i++) {
//    Serial.println(i);
   //EEPROM.write(i, 0);
  }

  Serial.println("leeeee");
 Serial.println(lee(70));
 Serial.println(lee(1));
 Serial.println(lee(30));

  // turn the LED on when we're done
  //digitalWrite(13, HIGH);
  Serial.println("termino");
}

void loop() {
  /** Empty loop. **/
}
