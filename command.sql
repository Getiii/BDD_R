CREATE  TABLE Membership(
	idMembership INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nameMembership	VARCHAR(20),
	maxPoint NUMERIC(5,0)
);

CREATE  TABLE Points(
	idPoints INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	numPoint INT,
	experyPoint DATE
);

CREATE  TABLE Clients (
	codeclient VARCHAR(50) PRIMARY KEY NOT NULL,
	nameClient VARCHAR(20),
	mailClient VARCHAR(20),
	facebook VARCHAR(20),
	instagram VARCHAR(20)
);

CREATE  TABLE Card(
	idCard INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	codeClient VARCHAR(50),
	idMembership INT,
	FOREIGN KEY (codeClient) REFERENCES Clients(codeClient),
	FOREIGN KEY (idMembership) REFERENCES Membership(idMembership)
);

CREATE  TABLE CartePoint(
	idCard INT,
	idPoints INT,
	FOREIGN KEY (idCard) REFERENCES Card(idCard),
	FOREIGN KEY (idPoints) REFERENCES Points(idPoints)
);

CREATE  TABLE Address(
	idAddress INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	countryCode VARCHAR(20),
	cityAddress VARCHAR(20),
	cityCode VARCHAR(20),
	streetAddress VARCHAR(20),
	numAddress VARCHAR(20),
	phoneAddress VARCHAR(20)
);

CREATE  TABLE Habite(
	codeClient VARCHAR(50),
	idAddress INT,
	PRIMARY KEY (codeClient, idAddress),
	FOREIGN KEY (codeClient) REFERENCES Clients(codeClient),
	FOREIGN KEY (idAddress) REFERENCES Address(idAddress)
);

CREATE  TABLE OrderStatus(
	idStatut INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	dateStatut DATE,
	typeStatut VARCHAR(20),
	CONSTRAINT CHK_Columnd_Type CHECK (typeStatut IN ('To Buy','Bought','Packed','Shipped','Arrived','Delivered','Done'))
);
	
CREATE  TABLE Command(
	idCommand INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	dateOrder DATE,
	noteOrder VARCHAR(50),
	delivry DATE,
	codeClient VARCHAR(50),
	idStatut INT,
	FOREIGN KEY (codeClient) REFERENCES Clients(codeClient),
	FOREIGN KEY (idStatut) REFERENCES OrderStatus(idStatut)
);

CREATE  TABLE Facture(
	numFacture INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	dateFacture DATE,
	idCommand INT,
	FOREIGN KEY (idCommand) REFERENCES Command(idCommand)
);

CREATE  TABLE Payement(
	idPayement INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	typePayement VARCHAR(20),
	datePayement DATE,
	amountPayement NUMERIC(7,2),
	idAdvancementPayement INT,
	FOREIGN KEY (idAdvancementPayement) REFERENCES Payement(idPayement)
);

CREATE  TABLE ItemStatus(
	idStatutItem INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	dateStatusItem DATE,
	typeStatusItem VARCHAR(20),
	CONSTRAINT CHK_Columnd_Type CHECK (typeStatusItem IN ('In Stock','Available','not Available','Out of stock','Free Gift','packed','Dispatched','Arrived','Delivred', 'Other'))
);

CREATE  TABLE Item(
	idItem INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nameItem VARCHAR(40),
	descItem VARCHAR(255),
	puItemRef NUMERIC(7,2),
	idStatutItem INT,
	FOREIGN KEY (idStatutItem) REFERENCES ItemStatus(idStatutItem)
);

CREATE  TABLE Compose(
	idCommand INT,
	idItem INT,
	qtyItem int,
	puItem numeric(6,2),
	FOREIGN KEY (idCommand) REFERENCES Command(idCommand),
	FOREIGN KEY (idItem) REFERENCES Item(idItem)
	
);

CREATE  TABLE Stock(
	idStock INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	qtyDispo INT,
	idItem INT,
	FOREIGN KEY (idItem) REFERENCES Item(idItem)
);

CREATE  TABLE Payer(
	numFacture INT,
	idPayement INT,
	PRIMARY KEY(numFacture, idPayement),
	FOREIGN KEY (numFacture) REFERENCES Facture(numFacture),
	FOREIGN KEY (idPayement) REFERENCES Payement(idPayement)
);


 INSERT INTO ITEM (idItem, nameItem, descItem, puItemRef) VALUES (DEFAULT, 'Codalie Duo Levre Main', '', 13.00);
 INSERT INTO ITEM (idItem, nameItem, descItem, puItemRef) VALUES (DEFAULT, 'Nuxe Lait Corps', '', 18.00);
 INSERT INTO ITEM (idItem, nameItem, descItem, puItemRef) VALUES (DEFAULT, 'Nuxe set Voyage', '', 29.00);
 INSERT INTO ITEM (idItem, nameItem, descItem, puItemRef) VALUES (DEFAULT, 'crème anti-rides BIO LA PROVENCALE', '', 49.00);
 INSERT INTO ITEM (idItem, nameItem, descItem, puItemRef) VALUES (DEFAULT, 'crème de nuit anti-âge bio N.A.E', '', 45.00);
 
 INSERT INTO CLIENTS (codeClient, nameClient, mailCLient,facebook, instagram) VALUE ('17-SPR-0001', 'Jean Michelle Moulin', 'jeanmi_300@yahoo.fr', 'JM Moulin','jmm20');
 
 
 