#include <stdio.h>
int main() {
    int a = 0;
    while (1) {
        a++; // Busy loop
        if (a % 10000000 == 0) printf(""); // Prevent optimizing out
    }
    return 0;
}
