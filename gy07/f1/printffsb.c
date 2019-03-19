#include <stdlib.h>
#include <stdio.h>

int main (int argc, char *argv[])
{
    char user_input[128];
    int *secret;
    int int_input;
    int some, variables;
    secret = (int *) malloc (4 * sizeof (int));
    secret[0] = SECRET0;
    secret[1] = SECRET1;
    secret[2] = SECRET2;
    secret[3] = SECRET3;
    printf("Turn off heap address randomization: sysctl -w kernel.randomize_va_space=0\n");
    printf("Please enter a decimal integer\n");
    scanf("%d", &int_input);
    printf("Please enter a string\n");
    scanf("%s", user_input);
    printf(user_input);
    printf("\n");
    if(secret[0] != SECRET0) {
        printf("1st value is overwritten!\n");
    }
    if(secret[1] != SECRET1) {
        printf("2nd value is overwritten!\n");
    }
    if(secret[2] != SECRET2) {
        printf("3rd value is overwritten!\n");
    }
    if(secret[3] != SECRET3) {
        printf("4th value is overwritten!\n");
    }
    free(secret);
    some = (int)&secret;
    return 0;
}
