const  fx:array[1..4,1..2] of integer=((-1,0),(0,1),(-1,-1),(-1,1)); 

var 
    ch:char; 
    ca:integer; 
    a:array[0..20,0..20] of char; 

procedure init; 
var 
    i,j,t1,t2:integer; 
begin 
    t1:=0; t2:=0; 
    for i:=1 to 15 do 
    begin 
        for j:=1 to 15 do 
        begin 
            read(a[i,j]); 
            if a[i,j]='B' then inc(t1) else 
            if a[i,j]='W' then inc(t2); 
        end; 
        readln; 
    end; 
    if t1=t2 then ch:='B' else ch:='W'; 
end; 


function check(x,y:integer):boolean; 
var 
    j,nx,ny,tot:integer; 
begin 
    for j:=1 to 4 do 
    begin 
        tot:=1; 
        nx:=x+fx[j,1]; ny:=y+fx[j,2]; 
        while a[nx,ny]=a[x,y] do 
begin 
    inc(tot); 
    nx:=nx+fx[j,1]; ny:=ny+fx[j,2]; 
end; 
nx:=x-fx[j,1]; ny:=y-fx[j,2]; 
while a[nx,ny]=a[x,y] do 
begin 
    inc(tot); 
    nx:=nx-fx[j,1]; ny:=ny-fx[j,2]; 
end; 
if tot>=5 then exit(true); 
                                                                                                                                                                                                                                                                                                                                                                            end; 
                                                                                                                                                                                                                                                                                                                                                                            exit(false); 
                                                                                                                                                                                                                                                                                                                                                                        end; 

procedure main; 
var 
    i,j:integer; 
    flag1,flag2:boolean; 
begin 
    flag1:=false; flag2:=false; 
    for i:=1 to 15 do 
        for j:=1 to 15 do 
            if a[i,j]='.' then 
            begin 
                a[i,j]:=ch; 
                if check(i,j) then 
                begin 
                    writeln('YES'); 
                    exit; 
                end; 
                a[i,j]:='.'; 
            end; 
            writeln('NO'); 
        end; 

begin 
    readln(ca); 
    for ca:=1 to ca do 
    begin 
        if ca>1 then readln; 
        init; 
        main; 
    end; 
end. 
