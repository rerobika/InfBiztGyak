#include <stdio.h>

unsigned mistakes(){
  int array[5];
  unsigned mistake = 7;
  int i = 0, pcs = 0;
  printf("Input count?");
  scanf("%d", &pcs);

  while(i < pcs) {
    printf("%d:", i);
    scanf("%x", &array[i]);
    i++;
  }

  printf("\n");
 
  return mistake;
}

int main() {
  unsigned score = 7;
  score -= mistakes();
  printf("%d\n", score);

  if(score < 10){
    printf("Bad\n");
  }
  else if(score < 50){
    printf("Not bad\n");
  }
  else if(score < 120){
    printf("Really good\n");
  }
  else{
    printf("God tier\n");
  }

  return 0;
}

