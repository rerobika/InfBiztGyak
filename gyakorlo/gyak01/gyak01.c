/**
* Mi a sérülékenység? Hogyan kell kijavítani?
* A sérülékenységet kihasználva találd meg SECRET decimális értékét és 
* azt is érd el, hogy a MESSAGE ki legyen írva!
* Csináld meg ezt gdb-vel is!
* Tipp: %n 
**/

#include <stdio.h>

int main(){
 char input[256];
 int secret = SECRET;
 int * psecret = 0;
 psecret = &secret;
 printf("%s\n","Give me an input:");
 fgets(input, 256, stdin);
 printf(input);
 if(secret != SECRET)
   printf("%s\n", MESSAGE);
 printf("Hints: %08x.%08x.%08x\n",psecret,&psecret,&secret);
 return 0;
}
