#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int checkuser(char *str) {
    char buf[8];
    gets(buf);
    puts(buf);
    return !strcmp(buf, str);
}

int main() {
    printf("Turn off heap address randomization: sysctl -w kernel.randomize_va_space=0\n");
    if(checkuser("pwd")) {//password from safe source
        printf("Access granted!\n");
    } else {
        printf("Access denied!\n");
    }
    return 0;
}
