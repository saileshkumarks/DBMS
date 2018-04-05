SELECT DISTINCT concat (d.FirstName,' ',d.LastName) AS Donor, p.PledgeId, TRUNC(p.PledgeDate), p.PledgeAmount, p.AmountPaid, SUM(a.Amount) AS MatchedAmount
    FROM Donor d, Pledge p, Payment a
    WHERE d.DonorId = p.DonorId
    AND p.PledgeId = a.PledgeId
    AND a.CompanyId is not Null	
    GROUP BY d.DonorId;