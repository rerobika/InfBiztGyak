/**
* Mik a sérülékenységek? Hogyan kell kijavítani?
* A sérülékenységeket kihasználva találd meg SECRET0 és SECRET1 értékeit
* Írasd ki a MESSAGE-t!
* Csináld meg ezt gdb-vel is!
**/

#include <stdio.h>

int main(){
 char input[256];
 int cycle[2];
 int secrets[4];
 secrets[0] = SECRET0 & 0x0000ffff;
 secrets[1] = SECRET1 & 0xffff0000;
 secrets[2] = SECRET0 & 0xffff0000;
 secrets[3] = SECRET1 & 0x0000ffff;
 cycle[1] = 0;
 unsigned int array[6];

 printf("%s\n","Give me an input:");
 fgets(input, 256, stdin);
 printf(input);

 printf("%s\n", "How many favourite hexadecimal numbers do you have?");
 scanf("%d", &cycle[0]);
 printf("%s\n", "Your favourite numbers:");
 while(cycle[1] < cycle[0]){
   printf("%d=",cycle[1]);
   scanf("%x", &array[cycle[1]++]);
 }

 printf(input);
 if(secrets[2] == SECRET1 && secrets[3] == SECRET0 && secrets[0] == (SECRET0 & 0x0000ffff) && secrets[1] == (SECRET1 & 0xffff0000))
   printf("%s\n", MESSAGE);

 return 0;
}
